<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=[
        'cars_id',
        'parkings_id',
        'startTime',
        'paidTime',
    ];
    public function Car(){
        return $this->belongsTo(Car::class);
    }
    public function Parking(){
        return $this->belongsTo(Parking::class);
    }
}
