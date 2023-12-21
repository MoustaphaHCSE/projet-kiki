<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCelebrityRequest;
use App\Http\Requests\UpdateCelebrityRequest;
use App\Models\Celebrity;

class CelebrityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCelebrityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Celebrity $celebrity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Celebrity $celebrity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCelebrityRequest $request, Celebrity $celebrity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Celebrity $celebrity)
    {
        //
    }
}
