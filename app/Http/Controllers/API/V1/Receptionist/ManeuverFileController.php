<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverExtensionResource;
use App\Http\Resources\ManeuverFileResource;
use App\Models\Maneuver;
use App\Models\ManeuverExtension;
use App\Models\ManeuverFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManeuverFileController extends BaseController
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
    public function store(Request $request, $id)
    {
        
        $request->validate([
            'file' => 'required|',
            'type' => 'required|string',
        ]);


        $maneuver = Maneuver::findOrFail($id);        

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $path = "maneuvers/{$id}";
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            Storage::disk('public')->putFileAs($path, $file, strtolower($request->type) . "." . $file->getClientOriginalExtension());
            $maneuverFile = new ManeuverFile();
            $maneuverFile->maneuver_id = $maneuver->id;
            $maneuverFile->type = $request->type;
            $maneuverFile->path = $path."/" . strtolower($request->type) . "." . $file->getClientOriginalExtension();
            $maneuverFile->file_extension = $file->getClientOriginalExtension();
            $maneuverFile->file_size = $file->getSize();
            $maneuverFile->save();

            if($request->type == 'Factura') {
                $client = $maneuver->client;
                if($client->firebase_web_token) {
                    try {
                        sendNotification(
                            'Nueva Factura',
                            'Se ha subido una nueva factura para la maniobra '.$maneuver->id,
                            [$client->firebase_web_token]
                        );
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    
                }
            }
                
        }

        return $this->sendResponse(new ManeuverFileResource($maneuverFile), 'File uploaded successfully.');
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
