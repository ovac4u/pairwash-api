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
        return (boolean) $this->user()->vehicles()->where('id', $this->input('vehicle_id'))->count();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vehicle_id' => 'required|numeric|exists:vehicles,id,user_id,' . $this->user()->id,
            'note' => 'required|string|min:25|max:250',
            'location' => 'required|string',
        ];
    }
}
