<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\ReservationSlot;
use App\Http\Requests\ReservationSlotRequest;
use App\Http\Requests\UpdateReservationSlotRequest;
use Carbon\Carbon;

class ReservationSlotController extends Controller
{
    public function index()
    {
        $reservation_slots = ReservationSlot::with('room')->orderBy('date', 'asc')->get();
        return view('admin.reservation_slots.index', compact('reservation_slots'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('admin.reservation_slots.create', compact('rooms'));
    }

    public function store(ReservationSlotRequest $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        while ($startDate->lte($endDate)) {
            ReservationSlot::create([
                'room_id' => $request->room_id,
                'date' => $startDate->format('Y-m-d'),
                'available_slots' => $request->available_slots,
                'price' => $request->price
            ]);
            $startDate->addDay();
        }

        return redirect()->route('admin.reservation_slots.index')->with('message', '予約枠を作成しました。');
    }

    public function edit(ReservationSlot $slot)
    {
        $rooms = Room::all();
        return view('admin.reservation_slots.edit', compact('slot', 'rooms'));
    }

    public function update(UpdateReservationSlotRequest $request, ReservationSlot $slot)
    {
        $slot->update([
            'room_id' => $request->room_id,
            'date' => $request->date,
            'available_slots' => $request->available_slots,
            'price' => $request->price
        ]);

        return redirect()->route('admin.reservation_slots.index')->with('message', '予約枠を更新しました。');
    }

    public function destroy(ReservationSlot $slot)
    {
        $slot->delete();

        return redirect(route('admin.reservation_slots.index'))->with('message', '予約枠を削除しました。');
    }
}
