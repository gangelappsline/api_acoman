<?php

namespace App\Http\Controllers\API\V1\Counter;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ManeuverResource;
use App\Models\Maneuver;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManueverController extends BaseController
{
    /**
     * Display a listing of the resource.
     * Gets maneuvers from the previous day (or weekend if Monday)
     */
    public function index(Request $request)
    {
        $today = Carbon::now();
        $dates = [];
        
        // Si es lunes (1), obtener viernes, sábado y domingo
        if ($today->dayOfWeek === Carbon::MONDAY) {
            $dates = [
                $today->copy()->subDays(3)->format('Y-m-d'), // Viernes
                $today->copy()->subDays(2)->format('Y-m-d'), // Sábado
                $today->copy()->subDays(1)->format('Y-m-d'), // Domingo
            ];
        } else {
            // Para cualquier otro día, obtener el día anterior
            $dates = [$today->copy()->subDay()->format('Y-m-d')];
        }

        if($request->query('from')) {
            $from = [Carbon::parse($request->query('from'))->format('Y-m-d')];
        }else{
            // Si no se proporciona 'from', usar la fecha de ayer
            $from = Carbon::yesterday()->format('Y-m-d');
        }

        if($request->query('to')) {
            $to = [Carbon::parse($request->query('to'))->format('Y-m-d')];
        }else{
            // Si no se proporciona 'to', usar la fecha de ayer
            $to = Carbon::yesterday()->format('Y-m-d');
        }

        $maneuvers = Maneuver::query()
            ->when($from ?? null, fn($query) => $query->where('programming_date', '>=', $from))
            ->when($to ?? null, fn($query) => $query->where('programming_date', '<=', $to))
            ->orderBy('programming_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return $this->sendResponse(ManeuverResource::collection($maneuvers), 'Previous day maneuvers retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        return $this->sendResponse(new ManeuverResource($maneuver), 'Maneuver retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->sendError('Not implemented', [], 501);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        
        if($request->has('paid')) {
            $maneuver->paid = true;            
        }

        $maneuver->save();

        return $this->sendResponse($maneuver, 'Maneuver updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
