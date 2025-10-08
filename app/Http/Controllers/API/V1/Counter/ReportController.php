<?php

namespace App\Http\Controllers\API\V1\Counter;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverPaymentResource;
use App\Models\ManeuverPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Toma toda la información de las maniobras del mes actual, es posible que te envien parametros para filtrar por rango de fecha, por clientes y si la maniobra esta pagada o no
        //$query = \App\Models\Maneuver::query();
        $query = ManeuverPayment::query();
        if(request()->query('from')) {
            $query->whereDate('created_at', '>=', request()->query('from'));
        }else{
            // Si no se proporciona 'from', usar el primer día del mes actual
            $query->whereDate('created_at', '>=', Carbon::yesterday()->format('Y-m-d'));
        }
        if(request()->query('to')) {
            $query->whereDate('created_at', '<=', request()->query('to'));
        }else{
            // Si no se proporciona 'from', usar el primer día del mes actual
            $query->whereDate('created_at', '<=', Carbon::yesterday()->format('Y-m-d'));
        }
        if(request()->query('paid')) {
            $query->where('status', request()->query('paid') == true ? 'confirmada':'pendiente');
        }

        if(request()->query('payment_method')) {
            $query->where('payment_method', request()->query('payment_method'));
        }
        $maneuvers =  $query->with('maneuver')->get();
        foreach ($maneuvers as $key => $maneuver) {
            $maneuver->client = $maneuver->maneuver->client;
        }
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
