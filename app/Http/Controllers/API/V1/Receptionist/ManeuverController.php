<?php

namespace App\Http\Controllers\API\V1\Receptionist;

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
        $maneuvers = Maneuver::orderBy('created_at', 'desc')->get(); // Aquí iría la lógica para obtener las maniobras
        return $this->sendResponse(ManeuverResource::collection($maneuvers), 'Maniobras retrieved successfully');
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
        $maneuver = Maneuver::findOrFail($id);
        $maneuver->status = $request->status;
        $maneuver->save();

        if ($maneuver->wasChanged('status')) {
            if ($maneuver->client->firebase_web_token != NULL) {

                sendNotification(
                    "Acoman - Actualización de Maniobra",
                    "La maniobra #{$maneuver->id} cambió su estado a {$maneuver->status}",
                    [$maneuver->client->firebase_web_token],
                    [
                        "time" => date("YmdHis"),
                        "image" => asset("images/logo.png"),
                        "title" => "Acoman - Actualización de Maniobra",
                        "body" => "La maniobra #{$maneuver->id} cambió su estado a {$maneuver->status}",
                        "route" => '/maneuvers/' . $maneuver->id
                    ]
                );
            }
        }

        
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
