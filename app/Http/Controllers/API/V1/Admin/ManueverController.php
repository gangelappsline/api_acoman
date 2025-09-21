<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use Illuminate\Http\Request;

class ManueverController extends BaseController
{
    public function index()
    {
        $maneuvers = Maneuver::all();
        return $this->sendResponse(ManeuverResource::collection($maneuvers), 'Maneuvers retrieved successfully.');
    }

    public function show($id)
    {
        $maneuver = Maneuver::findOrFail($id);
        return $this->sendResponse($maneuver, 'Maneuver retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required', 'pediment' => 'required', 'patent' => 'required', 
            'container' => 'required', 'product' => 'required', 'country' => 'required', 
            'bulks' => 'required', 'company' => 'required', 'importer' => 'required', 
            '200' => 'required', '500' => 'required',
        ]);
        
        $request->merge(['user_id' => auth()->user()->id]);
        $maneuver = Maneuver::create($request->except('_token'));
        return $this->sendResponse($maneuver, 'Maneuver created successfully.');
    }

    public function update(Request $request, $id)
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function destroy($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
