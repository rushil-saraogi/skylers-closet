<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'role' => ['required', Rule::in(['EMPLOYEE', 'ADMIN', 'OWNER'])],
            'email' => 'required|email|unique:users,email',
            'hotel_id' => 'required|exists:hotels,id',
        ];
    }
}
