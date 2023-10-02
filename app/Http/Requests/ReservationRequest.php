<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required|max:50',
            'first_name' => 'required|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
            'phone_number' => 'required|max:15|min:10',
            'message' => 'max:1000',
        ];
    }
}
