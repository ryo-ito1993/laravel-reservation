<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\ReservationSlot;

class ReservationSlotRequest extends FormRequest
{
    public function __construct()
    {
        Validator::extend('unique_room_date', function ($attribute, $value, $parameters, $validator) {
            $roomId = $validator->getData()['room_id'];
            $startDate = Carbon::parse($validator->getData()['start_date']);
            $endDate = Carbon::parse($validator->getData()['end_date']);
            $conflictingDates = [];

            while ($startDate->lte($endDate)) {
                $exists = ReservationSlot::where('room_id', $roomId)
                    ->where('date', $startDate->format('Y-m-d'))
                    ->exists();

                if ($exists) {
                    $conflictingDates[] = $startDate->format('Y-m-d');
                }

                $startDate->addDay();
            }
            if (!empty($conflictingDates)) {
                $validator->addReplacer('unique_room_date', function ($message, $attribute, $rule, $parameters) use ($conflictingDates) {
                    return str_replace(':dates', implode(', ', $conflictingDates), $message);
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'available_slots' => 'required|integer',
            'price' => 'required|integer',
        ];
    }
}
