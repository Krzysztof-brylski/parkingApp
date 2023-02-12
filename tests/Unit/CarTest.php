<?php

namespace Tests\Unit;
use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Plannr\Laravel\FastRefreshDatabase\Traits\FastRefreshDatabase;
use Tests\TestCase;

class CarTest extends TestCase
{
    use FastRefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_car()
    {
        $user=User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $response=$this->post(url("api/car/"),array(
            'users_id'=>$user->id,
            'registryPlate'=>"dw2312",
            'brand'=>"volkswagen",
            'color'=>"blue",
        ));
        $response->assertStatus(201);
        $this->assertDatabaseHas(Car::class,array(
            'users_id'=>$user->id,
            'registryPlate'=>"dw2312",
            'brand'=>"volkswagen",
            'color'=>"blue",
        ));

    }

    public function test_update_car(){

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

        $response=$this->put(route("car.update",["car"=>$car->id]),array(
            'registryPlate'=>"dw2222",
            'brand'=>"bmw",
            'color'=>"red",
        ));

        $response->assertStatus(200);
        $this->assertDatabaseHas(Car::class,array(
            'users_id'=>$user->id,
            'registryPlate'=>"dw2222",
            'brand'=>"bmw",
            'color'=>"red",
        ));
    }


    public function test_delete_car(){
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

        $response=$this->delete(route("car.update",["car"=>$car->id]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing(Car::class,array(
            'users_id'=>$user->id,
            'registryPlate'=>"dw2222",
            'brand'=>"bmw",
            'color'=>"red",
        ));
    }

}
