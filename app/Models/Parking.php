<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    protected $fillable=[
      'address',
      'city',
      'localization',
      'parkingSpots',
      'availableParkingSpots'
    ];

    public function makeReservation(){
        if( $this->availableParkingSpots>0){
            $this->availableParkingSpots-=1;
            $this->save();
            return "ok";
        }
        return "empty";
    }
    public function cancelReservation(){
        if($this->availableParkingSpots == $this->parkingSpots){
            return "empty";
        }
        $this->availableParkingSpots+=1;
        $this->save();
        return "ok";
    }
    public function Prices(){
        return $this->hasOne(Prices::class,'parkings_id');
    }
    public function Reservations(){
        return $this->hasMany(Reservation::class,'parkings_id');
    }
}
