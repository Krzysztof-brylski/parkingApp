<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */


    public function test_login()
    {

        Sanctum::actingAs(
            User::factory()->create()
        );
        $response = $this->get('/api/car');
        $response->assertOk();

    }
    public function test_user_delete(){

        $user = User::factory()->create();
        Sanctum::actingAs(
            $user
        );
        $response = $this->post('/api/user/delete');
        $response->assertStatus(200);
        $this->assertDatabaseMissing(User::class, $user->toArray());
    }

    public function test_auth_middleware(){
        $response = $this->get('/api/car');
        $response->assertStatus(302);

    }


}
