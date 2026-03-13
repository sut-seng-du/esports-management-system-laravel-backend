<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $bookings = $request->user()->bookings()->with('seats')->orderBy('date', 'desc')->get();

        return BookingResource::collection($bookings);
    }

    /**
     * Return occupied seat IDs for a given time range.
     */
    public function availability(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'exclude_booking_id' => 'sometimes|integer',
        ]);

        $occupiedSeats = \DB::table('booking_seat')
            ->join('bookings', 'booking_seat.booking_id', '=', 'bookings.id')
            ->where('bookings.date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('bookings.start_time', '<', $request->end_time)
                      ->where('bookings.end_time', '>', $request->start_time);
            })
            ->when($request->exclude_booking_id, function ($query) use ($request) {
                $query->where('bookings.id', '!=', $request->exclude_booking_id);
            })
            ->pluck('seat_id')
            ->unique()
            ->values();

        return response()->json([
            'occupied_seat_ids' => $occupiedSeats
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'seats' => 'required|array',
            'seats.*' => 'exists:seats,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // 1. Enforce 3-hour minimum
        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);
        if ($end->diffInMinutes($start) < 180) {
            return response()->json(['message' => 'Minimum booking duration is 3 hours.'], 422);
        }

        // 2. Check for overlaps
        $overlapCount = \DB::table('booking_seat')
            ->join('bookings', 'booking_seat.booking_id', '=', 'bookings.id')
            ->where('bookings.date', $request->date)
            ->whereIn('booking_seat.seat_id', $request->seats)
            ->where(function ($query) use ($request) {
                $query->where('bookings.start_time', '<', $request->end_time)
                      ->where('bookings.end_time', '>', $request->start_time);
            })
            ->count();

        if ($overlapCount > 0) {
            return response()->json(['message' => 'One or more selected seats are already booked for this time.'], 422);
        }

        $booking = $request->user()->bookings()->create([
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'confirmed' => false,
        ]);

        $booking->seats()->attach($request->seats);

        return response()->json([
            'message' => 'Booking created successfully',
            'data' => new BookingResource($booking->load('seats'))
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking): JsonResponse
    {
        // Ensure user can only update their own bookings
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'seats' => 'sometimes|array',
            'seats.*' => 'exists:seats,id',
            'date' => 'sometimes|date',
            'start_time' => 'sometimes',
            'end_time' => 'sometimes',
        ]);

        $date = $request->date ?? $booking->date;
        $startTime = $request->start_time ?? $booking->start_time;
        $endTime = $request->end_time ?? $booking->end_time;
        $seats = $request->seats ?? $booking->seats->pluck('id')->toArray();

        // 1. Enforce 3-hour minimum
        $start = \Carbon\Carbon::parse($startTime);
        $end = \Carbon\Carbon::parse($endTime);
        if ($end->diffInMinutes($start) < 180) {
            return response()->json(['message' => 'Minimum booking duration is 3 hours.'], 422);
        }

        // 2. Check for overlaps (excluding current booking)
        $overlapCount = \DB::table('booking_seat')
            ->join('bookings', 'booking_seat.booking_id', '=', 'bookings.id')
            ->where('bookings.id', '!=', $booking->id)
            ->where('bookings.date', $date)
            ->whereIn('booking_seat.seat_id', $seats)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('bookings.start_time', '<', $endTime)
                      ->where('bookings.end_time', '>', $startTime);
            })
            ->count();

        if ($overlapCount > 0) {
            return response()->json(['message' => 'One or more selected seats are already booked for this time.'], 422);
        }

        $booking->update([
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        if ($request->has('seats')) {
            $booking->seats()->sync($request->seats);
        }

        return response()->json([
            'message' => 'Booking updated successfully',
            'data' => new BookingResource($booking->load('seats'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        // Ensure user can only delete their own bookings
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ], 200);
    }
}
