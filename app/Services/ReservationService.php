<?php


namespace App\Services;


use App\Enum\ReservationStatusEnum;
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
            $fields['startTime'],
            $fields['timeZone']
        )->setTimezone(date_default_timezone_get());
        $endTime= Carbon::createFromFormat(
            'Y-m-d H:i',
            $fields['startTime'],
            $fields['timeZone']
        )->setTimezone(date_default_timezone_get());

        $endTime->addHours((int)$fields['paidTime']);
        $toPay = $parking->Prices->calculatePrice((int)$fields['paidTime']);
        $reservation=null;

        DB::transaction(function () use($startTime, $endTime, $car, $parking, $fields, $toPay,&$reservation){
            $reservation = Reservation::create([
                'startTime'=>$startTime->toDateTimeString(),
                'endTime'=>$endTime->toDateTimeString(),
                'timeZone'=>$fields['timeZone'],
            ]);
            $reservation->Car()->associate($car);
            $reservation->Parking()->associate($parking);
            $reservation->User()->associate(Auth::user());
            $reservation->save();
            $parking->makeReservation();


            $reservation->Payment()->create([
                'toPay'=>$toPay,
            ]);
        });
        return $reservation;
    }
    public function DeleteReservation(Reservation $reservation){
        db::transaction(function () use($reservation){
            $reservation->Parking->cancelReservation();
            $reservation->delete();
        });

    }
}
