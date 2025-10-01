<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Maneuver;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtener datos generales de maniobras, clientes, etc. para generar un dashboard de la mayoria de valores por ejemplo total de maniobras por status, maniobras que llegaran los siguientes 7 dias, total de clientes, etc.
        $totalManeuvers = Maneuver::count();
        $totalClients = User::where('role', 'cliente')->count();
        $upcomingManeuvers = Maneuver::where('programming_date', '>=', now())->count();
        $maneuvers = ["pendiente" => 0, "aceptada" => 0, "finalizada" => 0, "cancelada" => 0];
        foreach (Maneuver::all() as $maneuver) {
            $maneuvers[$maneuver->status]++;
        }

        return $this->sendResponse([
            'total_maneuvers' => $totalManeuvers,
            'total_active_clients' => User::where('role', 'cliente')->whereNotNull('email_verified_at')->count(),
            'total_clients' => $totalClients,
            'maneuvers_by_status' => $maneuvers,
            'upcoming_maneuvers' => $upcomingManeuvers,
        ], 'Dashboard data retrieved successfully');
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
