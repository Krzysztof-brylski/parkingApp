<?php


namespace App\Services;


use App\Enum\PaymentStatusEnum;
use App\Enum\ReservationStatusEnum;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * @param Payment $payment
     * @param $status
     */
    public function updateStatus(Payment $payment, $status)
    {
        if($status==PaymentStatusEnum::SUCCESS){
            $payment->update([
                'status'=>PaymentStatusEnum::SUCCESS,
            ]);
            return;
        }
        $payment->update([
            'status'=>PaymentStatusEnum::CANCEL,
        ]);
    }

    /**
     * @param Payment $payment
     * @return  $token
     */
    public function establishPayment(Payment $payment)
    {

        $token = Http::post("127.0.0.1:8888/",array(
            'originUrl'=>url("/"),
            'statusUpdateUrl'=>url("api/payment/"),
            'toPay'=>$payment->toPay,
            'clientEmail'=>$payment->Paymentable->User->email,
        ))->collect('token')->toArray()[0];
        $payment->token = $token;
        $payment->save();
    }

    /**
     * @param Payment $payment
     */
    public function changePaymentParentStatus(Payment $payment)
    {
        switch ($payment->status){
            case PaymentStatusEnum::SUCCESS:
                $startTime = Carbon::createFromFormat("Y-m-d H:i:s",$payment->Paymentable->startTime);
                if($startTime->lessThanOrEqualTo(Carbon::now())){
                    $payment->Paymentable->updateStatus(ReservationStatusEnum::ACTIVE);
                    break;
                }
                $payment->Paymentable->updateStatus(ReservationStatusEnum::AWAITING);

                break;
            case PaymentStatusEnum::CANCEL:
                $payment->Paymentable->updateStatus(ReservationStatusEnum::PAYMENT_CANCEL);
                break;
        }


    }
}
