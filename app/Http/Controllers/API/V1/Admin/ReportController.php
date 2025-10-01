<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\Maneuver;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    public function index()
    {
        //Get Maneuvers of the current month
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

    public function show($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
