<?php
namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

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
        
        $clients = $query->with('company')->paginate(15);
        return $this->sendResponse($clients, 'Clients retrieved successfully.');
    }

    public function show($id)
    {
        $client = User::where('role', 'cliente')->findOrFail($id);
        return $this->sendResponse($client, 'Client retrieved successfully.');
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
