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
        $request->validate([
            'name' => 'required|unique:services,name',
        ]);

        $service = Service::create($request->only('name', 'price'));
        return $this->sendResponse($service, 'Service created successfully.', 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:services,name,' . $id,
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->only('name', 'price'));
        return $this->sendResponse($service, 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return $this->sendResponse(null, 'Service deleted successfully.');
    }
}
