<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Room;
use App\Models\ReservationSlot;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationSendMail;
use App\Mail\ReservationAdminNotification;

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

    public function send(ReservationRequest $request, Plan $plan, ReservationSlot $slot)
    {
        $action = $request->input('action');
        $inputs = $request->except('action');

        if($action !== 'submit') {
            return redirect()
                ->route('reservation.create', ['plan' => $plan, 'slot' => $slot])
                ->withInput($inputs);

        } else {
            DB::transaction(function () use ($request, $inputs, $plan, $slot) {
                Reservation::create([
                    'plan_id' => $plan->id,
                    'reservation_slot_id' => $slot->id,
                    'last_name' => $inputs['last_name'],
                    'first_name' => $inputs['first_name'],
                    'email' => $inputs['email'],
                    'address' => $inputs['address'],
                    'phone_number' => $inputs['phone_number'],
                    'message' => $inputs['message'],
                ]);

                if ($slot->available_slots > 0) {
                    $slot->decrement('available_slots');
                }

                Mail::to($inputs['email'])->send(new ReservationSendMail($inputs, $plan, $slot));
                Mail::to('admin@example.com')->send(new ReservationAdminNotification($inputs, $plan, $slot));
                // //再送信を防ぐためにトークンを再発行
                $request->session()->regenerateToken();

                session(['reservation_completed' => true]);
            });

            return redirect()->route('reservation.complete', ['plan' => $plan, 'slot' => $slot]);
        }
    }

    public function complete(Plan $plan, ReservationSlot $slot)
    {
        if (!session('reservation_completed')) {
            return redirect()->route('top');
        }

        session()->forget('reservation_completed');

        return view('reservation.complete', ['plan' => $plan, 'slot' => $slot]);
    }
}
