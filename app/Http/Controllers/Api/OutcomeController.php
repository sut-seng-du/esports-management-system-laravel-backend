<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Outcome;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Outcome::latest()->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $outcome = Outcome::create($validated);
        return response()->json(['data' => $outcome], 201);
    }

    public function show(Outcome $outcome)
    {
        return response()->json(['data' => $outcome]);
    }

    public function update(Request $request, Outcome $outcome)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        $outcome->update($validated);
        return response()->json(['data' => $outcome]);
    }

    public function destroy(Outcome $outcome)
    {
        $outcome->delete();
        return response()->json(['message' => 'Outcome deleted']);
    }

    public function total()
    {
        $total = Outcome::sum('price');
        return response()->json(['total' => $total]);
    }
}
