<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Record::latest()->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seat' => 'nullable|string',
            'member_ID' => 'nullable|string',
            'member_amount' => 'nullable|numeric',
            'order' => 'nullable|string',
            'order_amount' => 'nullable|numeric',
            'total' => 'required|numeric',
            'paid' => 'required|boolean',
            'online' => 'required|boolean',
            'debt' => 'nullable|numeric',
        ]);

        $record = Record::create($validated);
        return response()->json(['data' => $record], 201);
    }

    public function show(Record $record)
    {
        return response()->json(['data' => $record]);
    }

    public function update(Request $request, Record $record)
    {
        $validated = $request->validate([
            'seat' => 'nullable|string',
            'member_ID' => 'nullable|string',
            'member_amount' => 'nullable|numeric',
            'order' => 'nullable|string',
            'order_amount' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'paid' => 'nullable|boolean',
            'online' => 'nullable|boolean',
            'debt' => 'nullable|numeric',
        ]);

        $record->update($validated);
        return response()->json(['data' => $record]);
    }

    public function destroy(Record $record)
    {
        $record->delete();
        return response()->json(['message' => 'Record deleted']);
    }

    public function topMembers()
    {
        $topMembers = Record::selectRaw('member_ID, SUM(total) as total_member_amount')
            ->whereNotNull('member_ID')
            ->groupBy('member_ID')
            ->orderByDesc('total_member_amount')
            ->limit(10)
            ->get();

        return response()->json(['data' => $topMembers]);
    }

    public function topDebtors(Request $request): JsonResponse
    {
        $limit = (int) $request->query('limit', 10);
        $limit = max(1, min($limit, 10000));

        $query = Record::select('member_ID', DB::raw('SUM(debt) as total_debt'))
            ->where('debt', '>', 0)
            ->whereNotNull('member_ID')
            ->where('member_ID', '!=', '')
            ->groupBy('member_ID')
            ->orderByDesc('total_debt');

        // Filter by specific date (e.g. ?date=today or ?date=2026-03-12)
        if ($request->filled('date')) {
            $date = $request->query('date');
            if ($date === 'today') {
                $date = now()->toDateString();
            }
            $query->whereDate('created_date', $date);
        }

        // Filter by month (e.g. ?month=2026-03)
        if ($request->filled('month')) {
            $month = $request->query('month');
            $query->where('created_date', 'like', $month . '%');
        }

        $topDebtMembers = $query->limit($limit)->get();

        return response()->json([
            'data' => $topDebtMembers,
        ]);
    }
}
