<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**This class has model observer **/
class Payment extends Model
{
    //use HasFactory;

    public $fillable=[
        'token',
        'status',
        'toPay',
    ];

    public function Paymentable()
    {
        return $this->morphTo();
    }

}
