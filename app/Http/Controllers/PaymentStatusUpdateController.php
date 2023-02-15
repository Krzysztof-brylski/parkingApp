<?php

namespace App\Http\Controllers;

use App\Enum\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PaymentStatusUpdateController extends Controller
{
    public function updateStatus(Payment $payment,Request $request){
        $fields=$request->all();
        (new PaymentService())->updateStatus($payment, $fields['status']);
        return Response()->json("OK",200);
    }
}
