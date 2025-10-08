<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ManeuverFileResource;
use App\Models\ManeuverFile;
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
            'file' => 'required|file',
            'type' => 'required|string',
        ]);
        //This could receive different types but the keys are dynamically generated
        $data = $request->all();
        $types = array("ine" => "INE", "license" => "Licencia de conducir");

        //El valor es "files"
        $file = $request->file("file");

            $file = $request->file("file");
                $type = $request->type;
                // Define the path where you want to store the file
                // Ensure the directory exists or create it
                $path = "maneuvers/{$id}";
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                Storage::disk('public')->putFileAs($path, $file, $type . "." . $file->getClientOriginalExtension());

                $fileM = new ManeuverFile();
                $fileM->maneuver_id = $id;
                $fileM->type = $type;
                $fileM->path = "maneuvers/{$id}/" . $type . "." . $file->getClientOriginalExtension();
                $fileM->file_extension = $file->getClientOriginalExtension();
                $fileM->file_size = $file->getSize();
                $fileM->save();
        /*foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $type = $request->type;
                // Define the path where you want to store the file
                // Ensure the directory exists or create it
                $path = "maneuvers/{$id}";
                if (!Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->makeDirectory($path);
                }
                Storage::disk('public')->putFileAs($path, $file, $type . "." . $file->getClientOriginalExtension());

                $fileM = new ManeuverFile();
                $fileM->maneuver_id = $id;
                $fileM->type = $types[$type];
                $fileM->path = "maneuvers/{$id}/" . $type . "." . $file->getClientOriginalExtension();
                $fileM->file_extension = $file->getClientOriginalExtension();
                $fileM->save();
            }
        }*/
        return $this->sendResponse($request->files, 'Maneuver files uploaded successfully.');
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
