<?php

namespace App\Models;

use App\Enum\ReservationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=[
        'cars_id',
        'parkings_id',
        'users_id',
        'status',
        'timeZone',
        'startTime',
        'endTime',
    ];

    protected $hidden=[
        'timeZone',
    ];

    public function updateStatus($enum){
        if($enum == ReservationStatusEnum::FINISHED){
            $this->status=$enum;
            $this->Parking->cancelReservation();
            $this->save();

            return;
        }

        $this->status=$enum;
        $this->save();
        return;
    }

    public function Payment()
    {
        return $this->morphOne(Payment::class, 'paymentable');
    }

    public function Car(){
        return $this->belongsTo(Car::class,'cars_id');
    }
    public function Parking(){
        return $this->belongsTo(Parking::class,'parkings_id');
    }
    public function User(){
        return $this->belongsTo(User::class,'users_id');
    }
}
