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
            'price' => 'nullable|numeric',
            'days' => 'nullable|integer',
            'double_maneuver' => 'nullable|boolean',
        ]);

        //Si el campo double_maneuver viene en la request, preguntar si el valor es "on" y ponerlo en true, sino en false
        if($request->has('double_maneuver')){
            $request->merge(['double_maneuver' => $request->double_maneuver === 'on' ? true : false]);
        } else {
            $request->merge(['double_maneuver' => false]);
        }        

        $service = Service::create($request->only('name', 'price', 'days', 'double_maneuver'));
        return $this->sendResponse($service, 'Service created successfully.', 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:services,name,' . $id,
            'price' => 'nullable|numeric',
            'days' => 'nullable|integer',
            'double_maneuver' => 'nullable|boolean',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->only('name', 'price', 'days', 'double_maneuver'));
        return $this->sendResponse($service, 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return $this->sendResponse(null, 'Service deleted successfully.');
    }
}
