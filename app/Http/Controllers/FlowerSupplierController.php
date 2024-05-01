<?php

namespace App\Http\Controllers;

use App\Models\FlowerSupplier;
use App\Http\Requests\StoreFlowerSupplierRequest;
use App\Http\Requests\UpdateFlowerSupplierRequest;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Flower;
class FlowerSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $flowerSuppliers = FlowerSupplier::all();
        return view('administrator.flowersupplier_list', compact('flowerSuppliers'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
   
public function create()
{
    $suppliers = Supplier::all();
    $flowers = Flower::all();
    return view('administrator.add_flowersupplier', compact('suppliers', 'flowers'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'supplier_id' => 'required|exists:suppliers,id',
        'flower_id' => 'required|exists:flowers,id',
        'price' => 'required|numeric|min:0',
        'stocks' => 'required|integer|min:0',
    ]);

    FlowerSupplier::create($validatedData);

    return redirect()->route('flowersuppliers.index')->with('success', 'Flower supplier added successfully');
}

    /**
     * Display the specified resource.
     */
    public function show(FlowerSupplier $flowerSupplier)
    {
        //
    }

    public function edit($id)
    {
        $flowersupplier = FlowerSupplier::findOrFail($id);
        $suppliers = Supplier::all();
        $flowers = Flower::all();
        return view('administrator.edit_flowersupplier', compact('flowersupplier', 'suppliers', 'flowers'));
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'flower_id' => 'required|exists:flowers,id',
            'price' => 'required|numeric|min:0',
            'stocks' => 'required|integer|min:0',
        ]);
    
        $flowersupplier = FlowerSupplier::findOrFail($id);
        $flowersupplier->update($validatedData);
    
        return redirect()->route('flowersuppliers.index')->with('success', 'Flower supplier updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlowerSupplier $flowersupplier)
    {
        $flowersupplier->delete();
        return redirect()->route('flowersuppliers.index')->with('success', 'Flower supplier deleted successfully');
    }
    
}
