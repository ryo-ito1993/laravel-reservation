<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Room;

class ReservationController extends Controller
{
    public function calender(Plan $plan, Room $room)
    {
        $rooms = Room::all();
        return view('reservation.calender', compact('plan', 'rooms', 'room'));
    }

}
