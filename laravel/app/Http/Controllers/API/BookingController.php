<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\FirebaseService;
use App\Models\User;



class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //list all bookings
    public function index()
    {

        // eager load relationships
        $bookings = Booking::with(['user:id,name,email', 'vehicle:id,make,model'])->get();
        return response()->json($bookings);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //create a new booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $booking = Booking::create($request->all());
        return response()->json($booking, 201);
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //show a specific booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'vehicle'])->find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        return response()->json($booking);
    }
    public function bookingsByUser($userId)
    {
        $bookings = Booking::with(['vehicle'])
            ->where('user_id', $userId)
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found for this user'], 404);
        }

        return response()->json($bookings);
    }

    //

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //update a booking
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'total_price' => 'numeric|min:0',
            'status' => 'string|in:pending,confirmed,cancelled,completed',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $booking->update($request->all());
        return response()->json($booking);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //delete a booking
    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
            //
        }
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }


    public function confirmBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'confirmed';
        $booking->save();

        // Send notification to the user
        $user = $booking->user; // assuming Booking has a 'user' relation
        if ($user && $user->fcm_token) {
            $firebase = new FirebaseService();
            $firebase->sendNotification(
                $user->fcm_token,
                'Booking Confirmed',
                'Your booking for ' . $booking->vehicle->make . ' ' . $booking->vehicle->model . ' has been confirmed!'
            );
        }

        return response()->json(['message' => 'Booking confirmed and notification sent']);
    }
}
