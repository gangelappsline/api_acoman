<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverFileResource;
use App\Models\ManeuverFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManeuverFileController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $maneuverId)
    {
        // Fetch files related to the maneuver
        $files = ManeuverFile::where('maneuver_id', $maneuverId)->get();
        return $this->sendResponse( ManeuverFileResource::collection($files), 'Maneuvers list.'); //response()->json($files);
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
        $types = array("ine"=>"INE", "license"=>"Licencia de conducir");
        if ($request->hasFile('file')) {
        $file = $request->file('file');
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
            $fileM->path = "maneuvers/{$id}/".$type . "." .$file->getClientOriginalExtension();
            $fileM->file_extension = $file->getClientOriginalExtension();
            $fileM->save();
            return response()->json(['file' => new ManeuverFileResource($fileM)], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400); 
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
