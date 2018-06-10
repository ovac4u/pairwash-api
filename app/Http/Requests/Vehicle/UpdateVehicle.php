<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->id === $this->route()->parameter('vehicle')->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand' => 'string|min:3|max:30',
            'color' => 'string|min:3|max:30',
            'type' => 'string|min:3|max:30|in:suv,wagon,saloon,scooter,trailer,motorcycle',
            'vln' => 'string|min:2|max:20|unique:vehicles,vln,' . $this->route()->parameter('vehicle')->id,
            'vcn' => 'string|min:10|max:50|unique:vehicles,vcn,' . $this->route()->parameter('vehicle')->id,
        ];
    }
}
