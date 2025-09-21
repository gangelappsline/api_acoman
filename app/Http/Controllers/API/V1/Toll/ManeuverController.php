<?php

namespace App\Http\Controllers\API\V1\Toll;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use Illuminate\Http\Request;

class ManeuverController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Today maneuvers for toll
        $maneuvers = Maneuver::where("check_in", today())->get();
        return $this->sendResponse(ManeuverResource::collection($maneuvers), 'Maneuvers retrieved successfully.');
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
    public function store(Request $request)
    {
        //
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
        //
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
