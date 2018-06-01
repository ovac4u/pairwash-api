<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicle extends FormRequest
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
            'brand' => 'required|string|min:3|max:30',
            'color' => 'required|string|min:3|max:30',
            'vln' => 'required|string|min:2|max:20|unique:vehicles',
            'vcn' => 'required|string|min:10|max:50|unique:vehicles',
            'type' => 'required|string|min:3|max:30|in:suv,wagon,saloon,scooter,trailer,motorcycle',
        ];
    }
}
