<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Announcement::where('active', true)
            ->where('start_datetime', '<=', now())
            ->where('end_datetime', '>=', now())
            ->latest()
            ->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date',
            'poster_image' => 'nullable|string',
            'active' => 'required|boolean',
        ]);

        $announcement = Announcement::create($validated);
        return response()->json(['data' => $announcement], 201);
    }

    public function show(Announcement $announcement)
    {
        return response()->json(['data' => $announcement]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'start_datetime' => 'nullable|date',
            'end_datetime' => 'nullable|date',
            'poster_image' => 'nullable|string',
            'active' => 'nullable|boolean',
        ]);

        $announcement->update($validated);
        return response()->json(['data' => $announcement]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(['message' => 'Announcement deleted']);
    }
}
