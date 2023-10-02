<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Room;
use App\Models\ReservationSlot;
use App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    public function calender(Plan $plan, Room $room)
    {
        $rooms = Room::all();
        return view('reservation.calender', compact('plan', 'rooms', 'room'));
    }

    public function create(Plan $plan, ReservationSlot $slot)
    {
        return view('reservation.create', compact('plan', 'slot'));
    }

    public function confirm(ReservationRequest $request, Plan $plan, ReservationSlot $slot)
    {
        return view('reservation.confirm', ['inputs' => $request->all(), 'plan' => $plan, 'slot' => $slot]);
    }
}
