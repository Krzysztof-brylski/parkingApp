<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\PaymentService;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        (new PaymentService())->establishPayment($payment);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        (new PaymentService())->changePaymentParentStatus($payment);
    }

}
