<?php
namespace App\Http\Controllers\API\V1\Toll;

use App\Http\Controllers\API\BaseController;
use App\Models\Maneuver;
use Illuminate\Http\Request;

class ManueverController extends BaseController
{
    public function index()
    {
        $maneuvers = Maneuver::whereDate("programming_date", date("Y-m-d"))->get();
        return $this->sendResponse($maneuvers, 'Maneuvers retrieved successfully.');
    }

    public function show($id)
    {
        return $this->sendError('Not implemented', [], 501);
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
