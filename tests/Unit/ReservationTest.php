<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\Parking;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;

class ReservationTest extends TestCase
{
    use FastRefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_reservation_create()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $car=Car::create([
            'users_id'=>$user->id,
            'registryPlate'=>"dw2312",
            'brand'=>"volkswagen",
            'color'=>"blue",
        ]);
        $parking=Parking::create([
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'users_id'=>$user->id,
            'parkingSpots'=>10,
            'availableParkingSpots'=>10
        ]);

        $response=$this->post(route("reservation.store"),array(
            'car_id'=>$car->id,
            'parking_id'=>$parking->id,
            'timeZone'=>'Europe/Warsaw',
            'startTime'=>"2024-01-01 12:12",
            'paidTime'=>2,
        ));
        $response->assertStatus(201);
        $this->assertDatabaseHas(Reservation::class,array(
            'cars_id'=>$car->id,
            'parkings_id'=>$parking->id,
            'timeZone'=>'Europe/Warsaw'
        ));
    }

    public function test_reservation_delete()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $car=Car::create([
            'users_id'=>$user->id,
            'registryPlate'=>"dw2312",
            'brand'=>"volkswagen",
            'color'=>"blue",
        ]);
        $parking=Parking::create([
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'users_id'=>$user->id,
            'parkingSpots'=>10,
            'availableParkingSpots'=>10
        ]);
        $reservation=Reservation::create([
            'cars_id'=>$car->id,
            'users_id'=>Auth::id(),
            'parkings_id'=>$parking->id,
            'timeZone'=>'Europe/Warsaw',
            'startTime'=>"2024-01-01 12:12",
            'endTime'=>"2024-01-01 13:12",
        ]);
        $response=$this->delete(route("reservation.destroy",["reservation"=>$reservation->id]));
        $response->assertStatus(200);
        $this->assertDatabaseMissing(Reservation::class,array(
            'id'=>$reservation->id,
        ));

    }

}
