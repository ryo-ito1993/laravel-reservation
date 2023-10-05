<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Mail\ReminderEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow();
        $reservations = Reservation::whereHas('reservation_slot', function ($query) use ($tomorrow) {
            $query->where('date', $tomorrow);
        })->where('status', 0)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->email)->send(new ReminderEmail($reservation));
        }
    }
}
