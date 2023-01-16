<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChargingStationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255|unique:charging_stations,name,' . $this->id,
            'working_time' => 'required|max:500',
            'description' => 'required|max:1000',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'charging_station_type_id' => 'required|exists:charging_station_types,id',
            'user_id' => 'required|exists:users,id',
            'plugTypes' => 'required',
            'paymentTypes' => 'required',
            'images' => 'required|array|max:5',
            'images.*' => 'image|max:2048',
            'publish' => 'boolean',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'latitude.between' => 'The latitude must be in range between -90 and 90',
            'longitude.between' => 'The longitude mus be in range between -180 and 180',
            'images.*.required' => 'Please upload at least one image',
            'images.*.image' => 'The files must be images',
        ];
    }
}
