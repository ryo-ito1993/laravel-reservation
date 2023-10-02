<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'reservation_slot_id',
        'last_name',
        'first_name',
        'email',
        'address',
        'phone_number',
        'message',
        'status',
        'note'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function reservation_slot()
    {
        return $this->belongsTo(ReservationSlot::class);
    }
}
