<?php

use App\Enum\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->nullable();
            $table->unsignedBigInteger('paymentable_id');
            $table->string('paymentable_type');
            $table->unsignedFloat('toPay');
            $table->enum('status',[
                PaymentStatusEnum::AWAITING, PaymentStatusEnum::SUCCESS,PaymentStatusEnum::CANCEL,
            ])->default(PaymentStatusEnum::AWAITING);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
