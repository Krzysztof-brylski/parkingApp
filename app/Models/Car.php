<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable=[
      'users_id',
      'registryPlate',
      'brand',
      'color',
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Reservations(){
        return $this->hasMany(Reservation::class);
    }

    use HasFactory;
}
