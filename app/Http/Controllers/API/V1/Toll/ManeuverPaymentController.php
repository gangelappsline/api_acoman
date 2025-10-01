<?php

namespace App\Http\Controllers\API\V1\Toll;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ManeuverFileResource;
use App\Models\ManeuverFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Maneuver;
use App\Models\ManeuverPayment;

class ManeuverPaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {
        $files = ManeuverFile::where("maneuver_id", $id)->get();
        return $this->sendResponse(ManeuverFileResource::collection($files), 'Maneuver files retrieved successfully.');
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
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $maneuver = Maneuver::findOrFail($id);

        $payment = new ManeuverPayment();
        $payment->maneuver_id = $maneuver->id;
        $payment->amount = $request->input('amount');
        $payment->notes = $request->input(key: 'description');
        $payment->created_by = $request->user()->id;
        $payment->payment_method = "efecticvo";
        $payment->save();
        return $this->sendResponse($payment, 'Maneuver payment created successfully.');
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
