<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    protected $fillable=[
      'parkings_id',
      'firstHour',
      'nextHours',
      'overTimeHours',
    ];

    public function Parking(){
        return $this->belongsTo(Parking::class);
    }


    use HasFactory;
}
