<?php

namespace App\Http\Controllers;

use App\Exports\CelebritiesExport;
use App\Http\Requests\StoreCelebrityRequest;
use App\Http\Requests\UpdateCelebrityRequest;
use App\Models\Celebrity;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
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
     * Gets the image url.
     */
    public function geturl(): string
    {
        return Storage::url($this->image);
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
        $celebrity->update($this->extractData($celebrity, $request));

        return redirect()->back()
            ->with('success', 'Profil wiki mis à jour.');
    }

    public function extractData(Celebrity $celebrity, StoreCelebrityRequest|UpdateCelebrityRequest $request): array
    {
        $data = $request->validated();
        /** @var UploadedFile|null $image */
        $image = $request->validated('image');
        if ($image !== null && !$image->getError()) {
            $data['image'] = $image->store('celebrity', 'public');
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCelebrityRequest $request, Celebrity $celebrity): RedirectResponse
    {
        $celebrity->create($this->extractData($celebrity, $request));
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

}
