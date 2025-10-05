<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = \App\Models\Service::all();
        return $this->sendResponse(ServiceResource::collection($services), 'Services retrieved successfully.');
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
    public function store(Request $request)
    {
        //
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
