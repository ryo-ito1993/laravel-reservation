<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\ReservationSlot;


class UpdateReservationSlotRequest extends FormRequest
{
    public function __construct()
    {
        Validator::extend('unique_room_date', function ($attribute, $value, $parameters, $validator) {
            $roomId = $value;
            $date = $validator->getData()['date'];
            $id = $this->route('slot')->id;

            $exists = ReservationSlot::where('room_id', $roomId)
                        ->where('date', $date)
                        ->where('id', '!=', $id)
                        ->exists();

            if ($exists) {
                $validator->addReplacer('unique_room_date', function ($message, $attribute, $rule, $parameters) use ($date) {
                    return str_replace(':date', $date, $message);
                });
                return false;
            }

            return true;
        });

    }

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
            'room_id' => 'required|exists:rooms,id|unique_room_date',
            'date' => 'required|date',
            'available_slots' => 'required|integer',
            'price' => 'required|integer',
        ];
    }
}
