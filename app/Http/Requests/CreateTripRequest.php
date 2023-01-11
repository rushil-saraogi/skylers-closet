<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTripRequest extends FormRequest
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
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'room_number' => 'required|numeric',
            'hotel_id' => 'required|exists:hotels,id',
            'guests' => 'required|array',
        ];
    }
}
