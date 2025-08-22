<?php

namespace App\Http\Controllers\API\V1;

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
        $manuevers = Maneuver::all();
        return $this->sendResponse( ManeuverResource::collection($manuevers), 'Maneuvers list.');
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
        $maneuver = Maneuver::find($id);

        if(!$maneuver) {
            return $this->sendError('Maneuver not found',[], 404);
        }

        if ($request->has('check_in')) {
            $maneuver->check_in = now();
            $maneuver->user_check_in = $request->user()->id;
        }

        if ($request->has('check_out')) {
            $maneuver->check_out = now();
            $maneuver->user_check_out = $request->user()->id;
        }

        $maneuver->save();

        return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
