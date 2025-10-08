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
        //Obten la cantidad de maniobras y el total agrupadas por dia de la semana actual con el siguiente formato: { day: "Lun", maniobras: 45, ingresos: 18500 }
        $data['weekly_distribution'] = \App\Models\Maneuver::selectRaw('COUNT(*) as maniobras, SUM(total) as ingresos, DAYOFWEEK(created_at) as dia')
            ->whereRaw('WEEK(created_at, 1) = WEEK(CURDATE(), 1)') // Semana actual
            ->groupBy('dia')
            ->get()
            ->map(function ($item) {
                return [
                    'day' => $this->threeLetterDay($item->dia),
                    'maniobras' => $item->maniobras,
                    'ingresos' => $item->ingresos
                ];
            });
        //Obtener el total de usuarios con rol 'client'
        $data['total_clients'] = \App\Models\User::where('role', 'cliente')->where("status", "Activo")->count();
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

    public function threeLetterDay($day)
    {
        $days = [
            1 => 'Dom',
            2 => 'Lun',
            3 => 'Mar',
            4 => 'Mié',
            5 => 'Jue',
            6 => 'Vie',
            7 => 'Sáb'
        ];
        return $days[$day] ?? '';
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
