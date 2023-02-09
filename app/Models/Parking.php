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

    public function Prices(){
        return $this->hasOne(Prices::class,'parkings_id');
    }
    public function Reservations(){
        return $this->hasMany(Reservation::class);
    }
}
