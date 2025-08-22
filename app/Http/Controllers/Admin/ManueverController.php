<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maneuver;
use Illuminate\Http\Request;

class ManueverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.maneuvers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.maneuvers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'pediment' => 'required',
            'patent' => 'required',
            'container' => 'required',
            'product' => 'required',
            'country' => 'required',
            'bulks' => 'required',
            'company' => 'required',
            'importer' => 'required',
            '200' => 'required',
            '500' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        Maneuver::create($request->except('_token'));
        return redirect()->url('/administrador/maniobras')->with('success', 'Maniobra guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maneuver = Maneuver::findOrFail($id); // Fetch the maneuver by ID if needed
        return view('admin.maneuvers.edit', compact('maneuver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
