<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class StoreBooking extends FormRequest
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
            'vehicle_id' => [
                'required',
                'numeric',
                'exists:vehicles,id,user_id,' . $this->user()->id,

                function ($attribute, $value, $fail) {

                    return
                    (
                        $this->user()->vehicles()->where('id', $this->input('vehicle_id'))->count() &&
                        !$this->user()->bookings()->where(['finished' => false, 'vehicle_id' => $this->input('vehicle_id')])->count()
                    )

                    ?: $fail('You already requested to wash this car.');
                },
            ],
            'note' => 'required|string|min:25|max:250',
            'location' => 'required|string',
        ];
    }
}
