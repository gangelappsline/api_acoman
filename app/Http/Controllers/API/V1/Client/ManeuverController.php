<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ManeuverResource;
use App\Mail\NewManeuverNotification;
use App\Models\Maneuver;
use App\Models\ManeuverContainer;
use App\Models\ManeuverPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ManeuverController extends BaseController
{
    public function index(Request $request)
    {
        $maneuvers = Maneuver::where("client_id", $request->user()->id)->get();
        return $this->sendResponse(ManeuverResource::collection($maneuvers), 'Maneuvers retrieved successfully.');
    }

    public function show($id)
    {
        $maneuver = Maneuver::find($id);
        if (!$maneuver) {
            return $this->sendError('Maneuver not found', [], 404);
        }
        return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver retrieved successfully.');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'pediment' => 'required|string|max:255',
                'patent' => "required|string|max:255",
                'container' => "required|string|max:255",
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
            $maneuver->client_id = $request->user()->id;
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

            $service = \App\Models\Service::find($request->service_id);
            if ($service->double_maneuver) {
                $maneuver2 = new Maneuver();
                $maneuver2->parent_id = $maneuver->id;
                $maneuver2->client_id = $request->user()->id;
                $maneuver2->created_by = $request->user()->id;
                $maneuver2->pediment = $request->pediment;
                $maneuver2->service_id = $request->service_id;
                $maneuver2->total = $request->total == '' ? 0 : $request->total / 2;
                $maneuver2->patent = $request->patent;
                $maneuver2->container = $request->container;
                $maneuver2->product = $request->product;
                $maneuver2->country = $request->country;
                $maneuver2->bulks = $request->bulks;
                $maneuver2->presentation = $request->presentation;
                $maneuver2->importer = $request->importer;
                $maneuver2->total = $request->total == '' ? 0 : $request->total;
                $maneuver2->folio_200 = $request->folio_200;
                $maneuver2->folio_500 = $request->folio_500;
                $maneuver2->company = $request->agency;
                //Suma los dias del servicio a la fecha de programacion
                if ($service->days) {
                    $maneuver2->programming_date_end = date('Y-m-d', strtotime($request->programming_date . " + {$service->days} days"));
                } else {
                    $maneuver2->programming_date_end = $request->programming_date;
                }

                $maneuver->total = $request->total == '' ? 0 : $request->total/2;
                $maneuver->save();
                $maneuver2->save();
            }

            if ($request->has("containers")) {
                foreach ($request->containers as $container) {
                    ManeuverContainer::create([
                        "maneuver_id" => $maneuver->id,
                        "code" => $container["code"],
                        "license_plate" => $container["license_plate"] ?? null,
                    ]);
                }
            }

            // Obtener recepcionistas para notificaciones
            $receptionists = User::where("role", "recepcionista")->get();
            
            // Enviar notificación push
            $tokens = $receptionists->whereNotNull("firebase_web_token")->pluck("firebase_web_token")->toArray();
            if (count($tokens) > 0) {
                sendNotification(
                    "Acoman - Nueva Maniobra",
                    "Se ha creado una nueva maniobra #{$maneuver->id}",
                    $tokens,
                    [
                        "time" => date("YmdHis"),
                        "image" => asset("images/logo.png"),
                        "title" => "Acoman - Nueva Maniobra",
                        "body" => "Se ha creado una nueva maniobra #{$maneuver->id}",
                        "route" => '/maneuvers'
                    ]
                );
            }
            
            // Enviar correo electrónico a recepcionistas
            $receptionistEmails = $receptionists->whereNotNull("email")->pluck("email")->toArray();
            if (count($receptionistEmails) > 0) {
                foreach ($receptionistEmails as $email) {
                    try {
                        Mail::to($email)->send(new NewManeuverNotification($maneuver));
                    } catch (\Exception $e) {
                        // Log error but don't fail the maneuver creation
                        Log::error('Failed to send maneuver notification email: ' . $e->getMessage());
                    }
                }
            }
            
            return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver created successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Error creating maneuver', [
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        if ($request->has("payment")) {
            ManeuverPayment::create([
                "maneuver_id" => $id,
                "amount" => $request->payment["amount"],
                "method" => $request->payment["method"],
                "status" => "completed",
                "created_by" => $request->user()->id,
            ]);

            $tokens = User::where("role", "contador")->whereNotNull("firebase_web_token")->pluck("firebase_web_token")->toArray();
            if (count($tokens) > 0) {
                sendNotification(
                    "Acoman - Pago de Maniobra",
                    "El cliente {$maneuver->client->name} ha realizado un pago para la maniobra #{$maneuver->id}",
                    $tokens,
                    [
                        "time" => date("YmdHis"),
                        "image" => asset("images/logo.png"),
                        "title" => "Acoman - Pago de Maniobra",
                        "body" => "El cliente {$maneuver->client->name} ha realizado un pago para la maniobra #{$maneuver->id}",
                        "route" => '/maneuvers'
                    ]
                );
            }
        }
        return $this->sendError('Not implemented', [], 501);
    }

    public function destroy($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
