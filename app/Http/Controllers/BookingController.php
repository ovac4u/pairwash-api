<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Requests\Booking\DeleteBooking;
use App\Http\Requests\Booking\StoreBooking;
use App\Http\Requests\Booking\UpdateBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->get();

        return responder()->success(['bookings' => $bookings]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBooking $request)
    {
        $booking = $request->user()->bookings()->make($request->validated());

        $booking->vehicle()->associate($request->input('vehicle_id'));

        $booking->save();

        return responder()->success(['booking' => $booking]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return responder()->success(['booking' => $booking]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBooking $request, Booking $booking)
    {
        $booking->update($request->validated());

        return responder()->success(['booking' => $booking]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteBooking $request, Booking $booking)
    {
        $booking->delete();

        return responder()->success(['booking' => $booking]);
    }
}
