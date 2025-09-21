<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->get();
        return $this->sendResponse($users, 'Users retrieved successfully.');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:7'
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['success' => true, 'user' => $user], 201);
    }
    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate(['name' => 'required']);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->save();
        return response()->json(['success' => true, 'user' => $user]);
    }
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['success' => true]);
    }
}
