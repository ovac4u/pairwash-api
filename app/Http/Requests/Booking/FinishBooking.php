<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class FinishBooking extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id' => [

                function ($attribute, $value, $fail) {

                    return

                    (
                        $this->user()->type == 'vendor' &&

                        $this->user()->has('acceptedBookings', function ($query) {
                            $query->where('booking_id', $this->route()->parameter('booking')->id);
                        })->count()
                    )

                    ?: $fail('You cannot finish a booking you never started.');
                },
            ],
        ];
    }
}
