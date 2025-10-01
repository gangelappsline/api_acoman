<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $query = \App\Models\Maneuver::query();
        if(request()->query('from')) {
            $query->whereDate('created_at', '>=', request()->query('from'));
        }
        if(request()->query('to')) {
            $query->whereDate('created_at', '<=', request()->query('to'));
        }
        if(request()->query('client_id')) {
            $query->where('client_id', request()->query('client_id'));
        }
        if(request()->query('paid')) {
            $query->where('paid', request()->query('paid'));
        }
        $maneuvers =  $query->get();
        return $this->sendResponse($maneuvers, 'Maneuvers retrieved successfully.');
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
