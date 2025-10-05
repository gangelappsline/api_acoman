<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverExtensionResource;
use App\Models\ManeuverExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManeuverExtensionController extends BaseController
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
            'type' => 'required',
            'days' => 'required|integer',
            'total' => 'required|numeric',
            'file' => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        $extension = new ManeuverExtension();
        $extension->maneuver_id = $id;
        $extension->type = $request->type;
        $extension->days = $request->days;
        $extension->total = $request->total;
        $extension->notes = $request->has('notes') ? $request->notes : null;
        $extension->paid = $request->has('paid') ? ($request->paid ? 1:0) : false;
        $extension->created_by = $request->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = "maneuvers/{$id}/extensions";
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $filePath = $path . "/" . $file->getClientOriginalName() . "." . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs($path, $file, basename($filePath));
            $extension->file = $filePath;
        }
        $extension->save();

        return $this->sendResponse(new ManeuverExtensionResource($extension), 'Maneuver extension created successfully.');
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
