<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class ConfigurationController extends BaseController
{
    public function index()
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
