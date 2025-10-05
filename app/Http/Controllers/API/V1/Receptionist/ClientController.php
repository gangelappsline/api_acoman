<?php

namespace App\Http\Controllers\API\V1\Receptionist;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeClientNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ClientController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::where('role', 'cliente')->orderBy('created_at', 'desc')->get(); // Aquí iría la lógica para obtener los clientes
        return $this->sendResponse($clients, 'Clients retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'credit' => 'nullable|numeric|min:0',
            'validation' => 'nullable|boolean',
        ]);
        
        // Guardar la contraseña original antes de encriptarla
        $originalPassword = $request->password;
        
        $client = new User();
        $client->name = $request->name;
        $client->email = $request->email;
        $client->role = 'cliente';
        $client->password = bcrypt($request->password);
        $client->credit = $request->credit ?? 0; // Valor por defecto
        $client->need_validation = $request->validation ?? true; // Valor por defecto
        $client->save();

        // Enviar correo de bienvenida
        try {
            Mail::to($client->email)->send(new WelcomeClientNotification($client, $originalPassword));
        } catch (\Exception $e) {
            Log::error('Error enviando correo de bienvenida: ' . $e->getMessage());
            // No fallar la creación del cliente si el correo falla
        }

        return $this->sendResponse($client, 'Client created successfully and welcome email sent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
