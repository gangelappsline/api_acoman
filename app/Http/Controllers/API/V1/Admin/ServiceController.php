<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    public function index()
    {
        $services = Service::all();
        return $this->sendResponse($services, 'Services retrieved successfully.');
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return $this->sendResponse($service, 'Service retrieved successfully.');
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
