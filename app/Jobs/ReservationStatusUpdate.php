<?php

namespace App\Jobs;

use App\Enum\ReservationStatusEnum;
use App\Models\Reservation;
use Illuminate\Support\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReservationStatusUpdate implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Reservation::where('status','!=','finished')->each(function (Reservation $reservation){


            //make carbon object from time strings
            $startTime = Carbon::createFromFormat("Y-m-d H:i:s",$reservation->startTime);
            $endTime = Carbon::createFromFormat("Y-m-d H:i:s",$reservation->startTime);

            //mark reservation as active while start time is equal orr greater than now
            if($reservation->status ==ReservationStatusEnum::AWAITING and
                $startTime->lessThanOrEqualTo(Carbon::now())
            ){

                $reservation->updateStatus(ReservationStatusEnum::ACTIVE);
                return true;
            }
            //mark reservation as finished while end time is equal orr greater than now
            if($reservation->status ==ReservationStatusEnum::ACTIVE and
                Carbon::now()->greaterThanOrEqualTo($endTime)
            ){
                $reservation->updateStatus(ReservationStatusEnum::FINISHED);
                return true;
            }
            return true;
        });
    }
}
