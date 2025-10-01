<?php

namespace App\Http\Controllers\API\V1\Counter;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ManeuverPayment;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obten los listados de pagos "ManeuverPayment", maniobras "Maneuver" y clientes "Client" del dia anterior, agrupados por el valor "payment_method" (transferencia o efectivo)
        $yesterday = now()->subDay()->format('Y-m-d');

        $transfers = ManeuverPayment::whereDate('created_at', $yesterday)->where('payment_method', 'transferencia')->sum('amount');
        $cash = ManeuverPayment::whereDate('created_at', $yesterday)->where('payment_method', 'efectivo')->sum('amount');

        //Obten todas las ordenes que no tienen pago registrado
        $unpaidManeuvers = \App\Models\Maneuver::whereDoesntHave('payments')->count();

        return $this->sendResponse([
            'transfers' => $transfers,
            'cash' => $cash,
            'unpaid_maneuvers' => $unpaidManeuvers
        ], 'Dashboard data retrieved successfully.');
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
