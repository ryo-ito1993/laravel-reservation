<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'date',
        'available_slots',
        'price',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
