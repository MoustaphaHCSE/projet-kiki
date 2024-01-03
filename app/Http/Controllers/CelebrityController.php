<?php

namespace App\Http\Controllers;

use App\Exports\CelebritiesExport;
use App\Http\Requests\StoreCelebrityRequest;
use App\Http\Requests\UpdateCelebrityRequest;
use App\Models\Celebrity;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CelebrityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-product|edit-product|delete-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('celebrities.index', [
            'celebrities' => Celebrity::orderBy('id', 'DESC')->paginate(3)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCelebrityRequest $request, Celebrity $celebrity): RedirectResponse
    {
        $requestImage = $request->file('image');
        if ($requestImage !== null && !$requestImage->getError()) {
            $fileName = pathinfo($request->file('image')->getClientOriginalName())['filename'];
            $extension = $request->file('image')->guessExtension();
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $fileName)));

            $path = sprintf('%s/celebrity/%s.%s', public_path('storage'), $slug, $extension);

            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->validated('image'));

            $image->toJpeg()->save($path);
        }
        $celebrity->create($request->validated());
        return redirect()->route('celebrities.index')
            ->with('success', 'Nouvelle célébrité ajoutée');
    }

    /**
     * Show the form for creating a new celebrity.
     */
    public function create(): View
    {
        return view('celebrities.create');
    }

    /**
     * Display a single celebrity.
     */
    public function show(Celebrity $celebrity): View
    {
        return view('celebrities.show', [
            'celebrity' => $celebrity
        ]);
    }

    /**
     * Displays the form to edit the celebrity
     */
    public function edit(Celebrity $celebrity): View
    {
        return view('celebrities.edit', [
            'celebrity' => $celebrity
        ]);
    }

    /**
     * Update the celebrity in storage.
     */
    public function update(UpdateCelebrityRequest $request, Celebrity $celebrity): RedirectResponse
    {
        $celebrity->update($request->all());
        return redirect()->back()
            ->with('success', 'Profil wiki mis à jour.');
    }

    /**
     * Remove the celebrity from storage.
     */
    public function destroy(Celebrity $celebrity): RedirectResponse
    {
        $celebrity->delete();
        return redirect()->route('celebrities.index')
            ->with('success', 'La célébrité n\'a plus aucune notoriété..');
    }

    public function exportCSV(): BinaryFileResponse
    {
        return Excel::download(new CelebritiesExport, 'celebrities-list.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * @param Celebrity $celebrity
     * @param StoreCelebrityRequest $request
     * @return array
     */
    private function extractData(Celebrity $celebrity, StoreCelebrityRequest $request): void
    {

    }

}
