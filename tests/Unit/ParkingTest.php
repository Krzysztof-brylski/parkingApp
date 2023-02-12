<?php

namespace Tests\Unit;
use App\Models\Car;
use App\Models\Parking;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;
class ParkingTest extends TestCase
{
    use FastRefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_parking()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $response=$this->post(route("parking.store"),array(
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'parkingSpots'=>10,
        ));

        $response->assertStatus(201);
        $this->assertDatabaseHas(Parking::class,array(
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'parkingSpots'=>10,
        ));

    }

    public function test_update_parking()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $parking=Parking::create([
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'users_id'=>$user->id,
            'parkingSpots'=>10,
            'availableParkingSpots'=>10
        ]);


        $response=$this->put(route("parking.update",['parking'=>$parking->id]),array(
            'address'=>'test st2',
            'city'=>'wroclaw2',
            'localization'=>'[21,21]',
            'parkingSpots'=>15,
        ));

        $response->assertStatus(200);
        $this->assertDatabaseHas(Parking::class,array(
            'id'=>$parking->id,
            'address'=>'test st2',
            'city'=>'wroclaw2',
            'localization'=>'[21,21]',
            'parkingSpots'=>15,
        ));

    }

    public function test_delete_parking()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $parking=Parking::create([
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'users_id'=>$user->id,
            'parkingSpots'=>10,
            'availableParkingSpots'=>10
        ]);


        $response=$this->delete(route("parking.destroy",['parking'=>$parking->id]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing(Parking::class,array(
            'address'=>'test st',
            'city'=>'wroclaw',
            'localization'=>'[19.0021,18.9921]',
            'parkingSpots'=>10,
        ));

    }
}
