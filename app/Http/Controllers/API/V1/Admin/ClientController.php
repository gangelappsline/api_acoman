<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends BaseController
{
    public function index(Request $request)
    {
        $query = User::where('role', 'cliente');
        
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'active') { $query->whereNotNull('email_verified_at'); }
            elseif ($status === 'inactive') { $query->whereNull('email_verified_at'); }
        }
        
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        if (in_array($sortField, ['name', 'email', 'created_at'])) {
            $query->orderBy($sortField, $sortDirection);
        } else { $query->orderBy('name', 'asc'); }
        
        $clients = $query->with('company')->get();
        return $this->sendResponse($clients, 'Clients retrieved successfully.');
    }

    public function show($id)
    {
        $client = User::where('role', 'cliente')->findOrFail($id);
        return $this->sendResponse($client, 'Client retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:7',
            'credit'=>'required',
            'status'=>'required',
        ]);

        $cliente = new User();
        $cliente->name = $request->name;
        $cliente->email = $request->email;
        $cliente->password = Hash::make($request->password);
        $cliente->credit = $request->credit;
        $cliente->status = $request->status;
        $cliente->role = 'cliente';
        $cliente->save();

        return $this->sendResponse($cliente, 'Client created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:7',
            'credit'=>'required',
            'active'=>'required',
        ]);

        $cliente = User::where('role', 'cliente')->findOrFail($id);
        $cliente->name = $request->name;
        $cliente->email = $request->email;
        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }
        $cliente->credit = $request->credit;
        $cliente->active = $request->active;
        $cliente->role = 'cliente';
        $cliente->save();

        return $this->sendResponse($cliente, 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $cliente = User::where('role', 'cliente')->findOrFail($id);
        $cliente->delete();
        return $this->sendResponse([], 'Client deleted successfully.');
    }
}
