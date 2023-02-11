<?php

use App\Enum\ReservationStatusEnum;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cars_id')->nullable()->constrained('cars');
            $table->foreignId('parkings_id')->nullable()->constrained('parkings');
            $table->foreignId('users_id')->nullable()->constrained('users');
            $table->string('timeZone');
            $table->enum('status',
                [ReservationStatusEnum::ACTIVE, ReservationStatusEnum::AWAITING, ReservationStatusEnum::FINISHED]
            );
            $table->dateTime('startTime');
            $table->dateTime('endTime');
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
        Schema::dropIfExists('reservations');
    }
};
