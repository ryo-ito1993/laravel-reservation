<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Plan;
use App\Models\Room;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancelMail;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        $date = $request->input('date');
        $email = $request->input('email');
        $plan = $request->input('plan');
        $room = $request->input('room');
        $status = $request->input('status');

        $plans = Plan::all();
        $rooms = Room::all();

        $reservations = Reservation::with('plan', 'reservation_slot.room')
            ->when($name, function ($query) use ($name) {
                $query->where(function ($query) use ($name) {
                    $query->where('last_name', 'like', "%{$name}%")
                            ->orWhere('first_name', 'like', "%{$name}%");
                });
            })
            ->when($email, function ($query) use ($email) {
                $query->where('email', 'like', "%{$email}%");
            })
            ->when($plan, function ($query) use ($plan) {
                $query->whereHas('plan', function ($query) use ($plan) {
                    $query->where('id', $plan);
                });
            })
            ->when($room, function ($query) use ($room) {
                $query->whereHas('reservation_slot.room', function ($query) use ($room) {
                    $query->where('id', $room);
                });
            })
            ->when($date, function ($query) use ($date) {
                $query->whereHas('reservation_slot', function ($query) use ($date) {
                    $query->where('date', $date);
                });
            })
            ->when($status !== null, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->get();
        return view('admin.reservations.index', compact('reservations', 'plans', 'rooms'));
    }



    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        DB::transaction(function () use ($request, $reservation) {
            $reservation->status = $request->status;
            $reservation->save();
            if ($request->status == "1") {
                if ($reservation->reservation_slot->available_slots < $reservation->reservation_slot->room->room_count) {
                    $reservation->reservation_slot->increment('available_slots');
                }
                Mail::to($reservation->email)->send(new ReservationCancelMail($reservation));
                }
            });
        return redirect()->back()->with('success', '予約状況が更新されました。');
    }

    public function updateNote(Request $request, Reservation $reservation)
    {
        $reservation->note = $request->note;
        $reservation->save();
        return redirect()->back()->with('success', 'メモが更新されました。');
    }
}
