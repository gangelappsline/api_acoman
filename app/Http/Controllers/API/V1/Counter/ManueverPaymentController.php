<?php

namespace App\Http\Controllers\API\V1\Counter;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Maneuver;
use App\Models\ManeuverPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManueverPaymentController extends BaseController
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

        $maneuver = Maneuver::findOrFail($id);

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
    public function update(Request $request, $maneuverId, string $id)
    {
        if($request->has("status")) {
            $payment = ManeuverPayment::findOrFail($id);
            $payment->status = $request->input("status");
            if($request->status == "rechazada") {
                $payment->rejected_by = $request->user()->id;
                $payment->rejected_notes = $request->input("reject_notes");
            }
            $payment->save();
            return $this->sendResponse($payment, 'Payment updated successfully.');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
