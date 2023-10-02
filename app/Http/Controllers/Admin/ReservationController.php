<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationCancelmail;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('plan', 'reservation_slot.room')->get();
        return view('admin.reservations.index', compact('reservations'));
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
            if ($reservation->reservation_slot->available_slots < $reservation->reservation_slot->room->room_count) {
                $reservation->reservation_slot->increment('available_slots');
            }
            Mail::to($reservation->email)->send(new ReservationCancelMail($reservation));
        });
        return redirect()->back()->with('success', '予約状況が更新されました。');
    }
}
