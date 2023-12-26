<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCelebrityRequest;
use App\Http\Requests\UpdateCelebrityRequest;
use App\Models\Celebrity;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CelebrityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('celebrities.index', [
            'celebrities' => Celebrity::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCelebrityRequest $request): RedirectResponse
    {
        Celebrity::create($request->all());
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

    /**
     * Restores the celebrity that's been soft-deleted.
     */
    public function restore(Celebrity $celebrity): RedirectResponse
    {
        $celebrity->restore();
        return redirect()->route('celebrities.index')
            ->with('success', 'L\'artiste a retrouvé sa célébrité..');
    }
}
