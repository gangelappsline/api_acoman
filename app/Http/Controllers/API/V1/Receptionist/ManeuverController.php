<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use App\Models\ManeuverContainer;
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
        try {
            $request->validate([
                'pediment' => 'required|string|max:255',
                'patent' => "required|string|max:255",
                'container' => "required|string|max:255",
                'client_id' => "required|exists:users,id",
                'service_id' => "required|exists:services,id",
                'product' => "required",
                'country' => "required",
                'bulks' => "required",
                'presentation' => "required",
                'importer' => "required",
                'folio_200' => "required",
                'folio_500' => "required",
                'agency' => "required",
                'programming_date' => "required",
            ]);

            $maneuver = new Maneuver();
            $maneuver->client_id = $request->client_id;
            $maneuver->created_by = $request->user()->id;
            $maneuver->pediment = $request->pediment;
            $maneuver->service_id = $request->service_id;
            $maneuver->patent = $request->patent;
            $maneuver->container = $request->container;
            $maneuver->product = $request->product;
            $maneuver->country = $request->country;
            $maneuver->bulks = $request->bulks;
            $maneuver->presentation = $request->presentation;
            $maneuver->importer = $request->importer;
            $maneuver->total = $request->total == '' ? 0 : $request->total;
            $maneuver->folio_200 = $request->folio_200;
            $maneuver->folio_500 = $request->folio_500;
            $maneuver->company = $request->agency;
            $maneuver->programming_date = $request->programming_date;
            $maneuver->save();

            if ($request->has("containers")) {
                foreach ($request->containers as $container) {
                    ManeuverContainer::create([
                        "maneuver_id" => $maneuver->id,
                        "code" => $container["code"],
                        "license_plate" => $container["license_plate"] ?? null,
                    ]);
                }
            }
            
            return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver created successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Error creating maneuver', [
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        
        return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver retrieved successfully.');
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
        if($request->has('status')) {
            $maneuver->status = $request->status;
            if($request->status == 'rechazada'){
                $maneuver->rejected_notes = $request->rejected_notes;
            }
        }

        if($request->has('total_amount')) {
            $maneuver->total = $request->total_amount;
        }
        $maneuver->save();

        if ($maneuver->wasChanged('total')) {
            if ($maneuver->client->firebase_web_token != NULL) {

                sendNotification(
                    "Acoman - Actualización de Maniobra",
                    "La maniobra #{$maneuver->id} cambió su monto total a {$maneuver->total}",
                    [$maneuver->client->firebase_web_token],
                    [
                        "time" => date("YmdHis"),
                        "image" => asset("images/logo.png"),
                        "title" => "Acoman - Actualización de Maniobra",
                        "body" => "La maniobra #{$maneuver->id} cambió su monto total a {$maneuver->total}",
                        "route" => '/maneuvers/' . $maneuver->id
                    ]
                );
            }
        }

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
