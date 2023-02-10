<?php


namespace App\DTO;


use App\Models\Reservation;
use Carbon\Carbon;

class ReservationDTO
{
    public $car;
    public $parking;
    public $startTime;
    public $endTime;

    public function __construct(Reservation $reservation)
    {
        $this->car=$reservation->Car()->get();
        $this->parking=$reservation->Parking()->get();

        $this->startTime=Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $reservation->startTime)->setTimeZone($reservation->timeZone);

        $this->endTime=Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $reservation->endTime)->setTimeZone($reservation->timeZone);
    }

    public function toArray(){
        return array(
            "car"=>$this->car,
            "parking"=>$this->parking,
            "startTime"=>$this->startTime->toDateTimeString(),
            "endTime"=>$this->endTime->toDateTimeString(),
        );
    }
}
