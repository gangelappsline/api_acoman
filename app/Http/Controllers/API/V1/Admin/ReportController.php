<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    public function index()
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function show($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
