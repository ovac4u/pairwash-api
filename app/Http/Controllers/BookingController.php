<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Requests\Booking\AcceptBooking;
use App\Http\Requests\Booking\DeleteBooking;
use App\Http\Requests\Booking\FinishBooking;
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
        $bookings = $request->user()->bookings()->with('vehicle')->get();

        return responder()->success(['bookings' => $bookings]);
    }

    /**
     * This method will get return all the
     * accepted and incomplete bookings.
     *
     * @param  Booking $booking The booking model found
     * @return \Illuminate\Http\Response
     */
    public function acceptedBooking(Request $request)
    {
        $bookings = Booking::with('user', 'vehicle')
            ->where('accepted', $request->user()->id)
            ->where('finished', false)->get();

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

    /**
     * Get the list of all opened bookings to find one
     *
     * @return \Illuminate\Http\Response
     */
    public function openBookings(Booking $booking)
    {
        $bookings = $booking->whereDoesntHave('provider')->with('vehicle', 'user')->get();

        return responder()->success(['bookings' => $bookings]);
    }

    /**
     * Get a list of all of the finished bookings
     * for the authenticated user
     *
     * @param  Request $request [description]
     * @return \Illuminate\Http\Response
     */
    public function finishedBookings(Request $request)
    {
        $user = $request->user();

        switch ($user->type) {
            case 'provider':
                $bookings = $user->acceptedBookings()->where('finished', true)->with('vehicle', 'user')->get();
                break;

            default:
                $bookings = $user->bookings()->where('finished', true)->get();
                break;
        }

        return responder()->success(['bookings' => $bookings]);
    }

    /**
     * This method will accept the booking if the
     * provider does not currently have
     * an incomplete booking
     *
     * @param  AcceptBooking $request Do the validation
     * @param  Booking $booking The booking model found
     * @return \Illuminate\Http\Response
     */
    public function acceptBooking(AcceptBooking $request, Booking $booking)
    {
        $booking->update(['accepted' => $request->user()->id]);

        return responder()->success(['booking' => $booking]);
    }

    /**
     * Mark booking as finished.
     *
     * @param  FinishBooking $request finish booking validation
     * @return \Illuminate\Http\Response
     */
    public function finishBooking(FinishBooking $request, Booking $booking)
    {
        $booking->update(['finished' => true]);

        return responder()->success(['booking' => $booking]);
    }
}
