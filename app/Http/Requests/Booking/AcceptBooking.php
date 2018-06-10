<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class AcceptBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        // !$this->route()->parameter('booking')->accepted;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [

                'bail',

                'required',

                function ($attribute, $value, $fail) {

                    return

                    ($this->user()->type == 'provider')

                    ?: $fail('Bookings can only be accepted by service providers.');
                },

                function ($attribute, $value, $fail) {

                    return

                    (!$this->user()->acceptedBookings()->where('finished', false)->count())

                    ?: $fail('You have an incomplete request. Finish that first.');
                },

                function ($attribute, $value, $fail) {

                    return

                    (!$this->route()->parameter('booking')->accepted == auth()->id())

                    ?: $fail('Someone else already accepted this request.');
                },

                function ($attribute, $value, $fail) {

                    return

                    (!$this->route()->parameter('booking')->accepted == auth()->id())

                    ?: $fail('You already accepted this request.');
                },
            ],
        ];
    }
}
