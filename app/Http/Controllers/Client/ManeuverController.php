<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ManeuverAdminNotification;
use App\Models\Country;
use App\Models\Maneuver;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManeuverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.maneuvers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where("user_id", auth()->user()->id)->get();
        $countries = Country::orderBy('name','ASC')->get();
        return view('client.maneuvers.create', compact('products', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pediment' => 'required',
            'patent' => 'required',
            'container' => 'required',
            'product' => 'required',
            'country' => 'required',
            'bulks' => 'required',
            'presentation' => 'required',
            'importer' => 'required',
            'folio_200' => 'required',
            'folio_500' => 'required',
        ]);

        $request->merge(['created_by' => auth()->user()->id,'client_id' => auth()->user()->id,'company' => auth()->user()->company->name, ]);

        if ($request->product_id == "") {
            Product::create([
                'name' => $request->product,
                'user_id' => auth()->user()->id,
            ]);            
        }

        $maneuver = Maneuver::create($request->except('_token','_method','product_name'));
        Mail::to("angelgrcroguez@gmail.com")->send(new ManeuverAdminNotification($maneuver));
        return redirect('/cliente/maniobras')->with('success', 'Maniobra guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        $products = Product::where("user_id", auth()->user()->id)->get();
        $countries = Country::orderBy('name','ASC')->get();
        return view('client.maneuvers.show', compact('maneuver', 'products', 'countries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maneuver = Maneuver::findOrFail($id);
        $products = Product::where("user_id", auth()->user()->id)->get();
        $countries = Country::orderBy('name','ASC')->get();
        return view('client.maneuvers.edit', compact('maneuver', 'products', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'pediment' => 'required',
            'patent' => 'required',
            'container' => 'required',
            'product' => 'required',
            'country' => 'required',
            'bulks' => 'required',
            'presentation' => 'required',
            'importer' => 'required',
            'folio_200' => 'required',
            'folio_500' => 'required',
        ]);

        $maneuver = Maneuver::findOrFail    ($id);
        $request->merge(['created_by' => auth()->user()->id,'client_id' => auth()->user()->id,'company' => auth()->user()->company->name, ]);

        if ($request->product_id == "") {
            Product::create([
                'name' => $request->product_name,
                'user_id' => auth()->user()->id,
            ]);            
        }

        $maneuver->update($request->except('_token','_method','product_name'));
        return redirect('/cliente/maniobras')->with('success', 'Maniobra modificada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
