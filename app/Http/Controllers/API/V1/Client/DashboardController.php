<?php
namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
