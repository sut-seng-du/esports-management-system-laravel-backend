<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Inventory::latest()->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'type' => 'nullable|string',
        ]);

        $inventory = Inventory::create($validated);
        return response()->json(['data' => $inventory], 201);
    }

    public function show(Inventory $inventory)
    {
        return response()->json(['data' => $inventory]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'item_name' => 'nullable|string',
            'qty' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'type' => 'nullable|string',
        ]);

        $inventory->update($validated);
        return response()->json(['data' => $inventory]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['message' => 'Inventory deleted']);
    }

    public function updateQuantity(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'qty' => 'required|numeric',
        ]);

        $inventory->update(['qty' => $validated['qty']]);
        return response()->json(['data' => $inventory]);
    }
}
