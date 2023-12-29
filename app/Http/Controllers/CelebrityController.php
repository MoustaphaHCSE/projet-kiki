<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCelebrityRequest;
use App\Http\Requests\UpdateCelebrityRequest;
use App\Models\Celebrity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

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
        Log::channel('celebrity-crud')->info('displaying all celebrities');

        return view('celebrities.index', [
            'celebrities' => Celebrity::orderBy('id', 'DESC')->paginate(3)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCelebrityRequest $request): RedirectResponse
    {
        Celebrity::create($request->all());
        Log::channel('celebrity-crud')->info('adding a new celebrity');

        return redirect()->route('celebrities.index')
            ->with('success', 'Nouvelle célébrité ajoutée');
    }

    /**
     * Show the form for creating a new celebrity.
     */
    public function create(): View
    {
        Log::channel('celebrity-crud')->info('creating new celebrity');

        return view('celebrities.create');
    }

    /**
     * Display a single celebrity.
     */
    public function show(Celebrity $celebrity): View
    {
        Log::channel('celebrity-crud')->info(sprintf('showing celebrity %s', $celebrity->last_name));

        return view('celebrities.show', [
            'celebrity' => $celebrity
        ]);
    }

    /**
     * Displays the form to edit the celebrity
     */
    public function edit(Celebrity $celebrity): View
    {
        Log::channel('celebrity-crud')->info(sprintf('editing celebrity %s\'s profile', $celebrity->last_name));

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
        Log::channel('celebrity-crud')->info(sprintf('updating celebrity %s\'s profile', $celebrity->last_name));

        return redirect()->back()
            ->with('success', 'Profil wiki mis à jour.');
    }

    /**
     * Remove the celebrity from storage.
     */
    public function destroy(Celebrity $celebrity): RedirectResponse
    {
        $celebrity->delete();
        Log::channel('celebrity-crud')->info(sprintf('deleted celebrity %s with id %s', $celebrity->last_name, $celebrity->id));

        return redirect()->route('celebrities.index')
            ->with('success', 'La célébrité n\'a plus aucune notoriété..');
    }
}
