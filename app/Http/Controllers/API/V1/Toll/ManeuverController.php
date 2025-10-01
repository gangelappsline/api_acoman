<?php

namespace App\Http\Controllers\API\V1\Toll;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use App\Models\ManeuverData;
use App\Models\User;
use Illuminate\Http\Request;

class ManeuverController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Today maneuvers for toll
        $maneuvers = Maneuver::where("programming_date", today())->get();
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
        try {
            $maneuver = Maneuver::findOrFail($id);
            

            if ($request->has('data')) {
                foreach ($request->data as $item) {
                    $data = new ManeuverData();
                    $data->maneuver_id = $maneuver->id;
                    $data->data_key = $item['key'];
                    $data->data_value = $item['value'];
                    $data->save();
                }
            }

            if ($request->has('check_in')) {
                $maneuver->check_in = date("Y-m-d H:i:s", strtotime($request->check_in));
                $tokens = User::where("role", "recepcionista")->whereNotNull("firebase_web_token")->pluck("firebase_web_token")->toArray();
                if (count($tokens) > 0) {
                    sendNotification(
                        "Acoman - Entrada de Maniobra",
                        "Se ha registrado la entrada de la maniobra #{$maneuver->id}",
                        $tokens,
                        [
                            "time" => date("YmdHis"),
                            "image" => asset("images/logo.png"),
                            "title" => "Acoman - Entrada de Maniobra",
                            "body" => "Se ha registrado la entrada de la maniobra #{$maneuver->id}",
                            "route" => '/maneuvers'
                        ]
                    );
                }
            }
            if ($request->has('check_out')) {
                $maneuver->check_out = date("Y-m-d H:i:s", strtotime($request->check_out));
                $tokens = User::where("role", "recepcionista")->whereNotNull("firebase_web_token")->pluck("firebase_web_token")->toArray();
                if (count($tokens) > 0) {
                    sendNotification(
                        "Acoman - Salida de Maniobra",
                        "Se ha registrado la salida de la maniobra #{$maneuver->id}",
                        $tokens,
                        [
                            "time" => date("YmdHis"),
                            "image" => asset("images/logo.png"),
                            "title" => "Acoman - Salida de Maniobra",
                            "body" => "Se ha registrado la salida de la maniobra #{$maneuver->id}",
                            "route" => '/maneuvers'
                        ]
                    );
                }
            }

            $maneuver->save();

            return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver updated successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Error updating maneuver', [
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
