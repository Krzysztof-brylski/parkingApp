<?php


namespace App\Services;


use App\Models\Car;
use App\Models\Parking;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationService
{




    public function CreateReservation(array $fields){

        $car = Car::where('id','=',$fields['car_id'])->first();
        $parking = Parking::where('id','=',$fields['parking_id'])->first();

        $startTime= Carbon::createFromFormat(
            'Y-m-d H:i',
            $fields['startTime']
        );
        $endTime= Carbon::createFromFormat(
            'Y-m-d H:i',
            $fields['startTime']
        );
        $endTime->addHours((int)$fields['paidTime']);
        DB::transaction(function () use($startTime,$endTime, $car, $parking, $fields){

            $reservation = Reservation::create([
                'startTime'=>$startTime->toDateTimeString(),
                'endTime'=>$endTime->toDateTimeString(),
                'timeZone'=>$fields['timeZone']
            ]);
            $reservation->Car()->associate($car);
            $reservation->Parking()->associate($parking);
            $reservation->User()->associate(Auth::user());
            $reservation->save();
            $parking->makeReservation();
        });

    }
    public function DeleteReservation(Reservation $reservation){
        DB::transaction(function () use($reservation){
            $reservation->delete();
            $reservation->Parking()->cancelReservation();
        });

    }
}
