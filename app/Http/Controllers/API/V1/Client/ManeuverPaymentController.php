<?php

namespace App\Http\Controllers\API\V1\Client;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\NewPaymentNotification;
use App\Models\Maneuver;
use App\Models\ManeuverPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ManeuverPaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'reference' => 'required|string',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $maneuver =  Maneuver::findOrFail($id);
        $payment = new ManeuverPayment();
        $payment->maneuver_id = $maneuver->id;
        $payment->amount = $request->input('amount');
        $payment->reference = $request->input('reference');
        $payment->created_by = $request->user()->id;
        $payment->payment_method = "transferencia";
        $payment->save();

        if($request->hasFile('receipt')) {
            $file = $request->file('receipt');            
            $path = "maneuvers/{$id}";
            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            Storage::disk('public')->putFileAs($path, $file, "transferencia" . "." . $file->getClientOriginalExtension());
            $payment->payment_file = $path."/transferencia" . "." . $file->getClientOriginalExtension();
            $payment->save();
        }

        // Obtener contadores para notificaciones
        $counters = User::where('role', 'contador')->get();
        
        // Enviar notificación push
        $counterTokens = $counters->whereNotNull('firebase_web_token')->pluck('firebase_web_token')->toArray();
        if (count($counterTokens) > 0) {
            sendNotification(
                "Acoman - Nuevo pago de Maniobra",
                "Se ha creado un nuevo pago para la maniobra #{$maneuver->id}",
                $counterTokens,
                [
                    "time" => date("YmdHis"),
                    "image" => asset("images/logo.png"),
                    "title" => "Acoman - Nuevo pago de Maniobra",
                    "body" => "Se ha creado un nuevo pago para la maniobra #{$maneuver->id}",
                    "route" => '/maneuvers'
                ]
            );
        }
        
        // Enviar correo electrónico a contadores
        $counterEmails = $counters->whereNotNull('email')->pluck('email')->toArray();
        if (count($counterEmails) > 0) {
            foreach ($counterEmails as $email) {
                try {
                    $attachments = [Storage::disk('public')->url($payment->payment_file)];
                    Mail::to($email)->send(new NewPaymentNotification($payment, $attachments));
                } catch (\Exception $e) {
                    // Log error but don't fail the payment creation
                    Log::error('Failed to send payment notification email: ' . $e->getMessage());
                }
            }
        }

        return $this->sendResponse($payment, 'Payment created successfully.');
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
