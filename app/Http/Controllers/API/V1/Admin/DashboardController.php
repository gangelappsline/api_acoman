<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        //Obten la suma total de la columna "total" de "Maneuver" agrupado por mes con este formato: { month: 'Jul', amount: 85000, label: 'Julio' },
        
        $data = [];

        //Obtener el total de maniobras del mes actual
        $currentMonth = date('n');
        $maneuversMonth = \App\Models\Maneuver::whereRaw('MONTH(created_at) = ?', [$currentMonth])->get();
        $data['total_maneuvers_current_month'] = $maneuversMonth->count();
        $data['total_revenue_current_month'] = $maneuversMonth->sum('total');
        $maneuvers = \App\Models\Maneuver::selectRaw('SUM(total) as total, MONTH(created_at) as month')
            ->groupBy('month')
            ->get();
        $data['monthly_revenue'] = $maneuvers->map(function ($item) {
            return [
                'month' => $this->threeLetterMonth($item->month),
                'amount' => $item->total,
                'label' => $this->getMonthName($item->month)
            ];
        });

        //Obten la cantidad de maniobras agrupadas por servicio con este formato: { name: 'Carga', value: 35, color: '#3B82F6' },
        $data['service_distribution'] = \App\Models\Maneuver::selectRaw('COUNT(*) as value, service_id')
            ->groupBy('service_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $this->getServiceName($item->service_id),
                    'value' => $item->value,
                    'color' => $this->getServiceColor($item->service_id)
                ];
            });
        return $this->sendResponse($data, 'Dashboard data retrieved successfully.');
    }

    private function getServiceName($serviceId)
    {
        $services = Service::find($serviceId);
        return $services ? $services->name : 'Desconocido';
    }

    private function getServiceColor($serviceId)
    {
        $colors = [
            1 => '#3B82F6', // Carga
            2 => '#10B981', // Descarga
            3 => '#F59E0B', // Almacenaje
            4 => '#EF4444', // Transporte
            5 => '#8B5CF6', // Otros
            6 => '#D97706', // Aduana
            7 => '#14B8A6', // Inspección
            8 => '#E11D48', // Seguro
            9 => '#6366F1', // Logística
            10 => '#F97316', // Consultoría
            11 => '#22D3EE', // Embalaje
            12 => '#A78BFA' // Manipulación
        ];
        return $colors[$serviceId] ?? '#6B7280'; // Default color (gray) if service ID not found
    }

    private function threeLetterMonth($month)
    {
        $months = [
            1 => 'Ene',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dic'
        ];
        return $months[$month] ?? '';
    }


    
    private function getMonthName($month)
    {
        $months = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        return $months[$month] ?? '';
    }
}
