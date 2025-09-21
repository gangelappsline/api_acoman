<?php
namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use Illuminate\Http\Request;

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
        return $this->sendError('Not implemented', [], 501);
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
