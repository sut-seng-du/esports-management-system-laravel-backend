<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Pricing::orderBy('hour')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'hour' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $pricing = Pricing::create($validated);
        return response()->json(['data' => $pricing], 201);
    }

    public function show(Pricing $pricing)
    {
        return response()->json(['data' => $pricing]);
    }

    public function update(Request $request, Pricing $pricing)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'hour' => 'nullable|numeric',
            'price' => 'nullable|numeric',
        ]);

        $pricing->update($validated);
        return response()->json(['data' => $pricing]);
    }

    public function destroy(Pricing $pricing)
    {
        $pricing->delete();
        return response()->json(['message' => 'Pricing deleted']);
    }
}
