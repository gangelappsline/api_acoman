<?php
namespace App\Http\Controllers\API\V1\Toll;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->sendError('Not implemented', [], 501);
    }

    public function login(Request $request)
    {
        $request->validate(['code' => 'required|string|digits:6']);
        $user = \App\Models\User::where('code', $request->code)->where('role', 'caseta')->first();
        
        if ($user) {
            Auth::login($user);
            return $this->sendResponse(['user' => $user], 'Login successful.');
        }
        
        return $this->sendError('Invalid credentials', [], 401);
    }
}
