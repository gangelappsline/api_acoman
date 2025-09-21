<?php
namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index()
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function show($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function store(Request $request)
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function update(Request $request, $id)
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function destroy($id)
    {
        return $this->sendError('Not implemented', [], 501);
    }
}
