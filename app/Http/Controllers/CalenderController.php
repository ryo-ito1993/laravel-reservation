<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationSlot;
use App\Models\Plan;
use App\Models\Room;
use Carbon\Carbon;

class CalenderController extends Controller
{
    public function index(Plan $plan, Room $room)
    {
        $slots = ReservationSlot::where('room_id', $room->id)->where('date', '>=', Carbon::tomorrow())->get();
        $events = [];
        foreach ($slots as $slot) {
            if ($slot->available_slots >= 3) {
                $slot_symbol = '○';
            } elseif ($slot->available_slots >= 1) {
                $slot_symbol = '△';
            } else {
                $slot_symbol = 'x';
            }
            $events[] = [
                'id' => $slot->id,
                'available_slots' => $slot->available_slots,
                'title' => $slot_symbol . '|' . '¥' . number_format($slot->price + $plan->price),
                'start' => $slot->date,
            ];
        }
        return response()->json($events);
    }
}
