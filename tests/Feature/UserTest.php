<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_register(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/users/register',$this->getData());
        $user = User::first();

        $this->assertCount(1,User::all());
        $response->assertJson([
            'name'=>'John Doe',
            'email'=>'JohnDoe@test.com',
            'api_token'=>$user->api_token
        ]);
    }


    private function getData(){
        return [
            'name'=>'John Doe',
            'email'=>'JohnDoe@test.com',
            'password'=>'password',
            'password_confirmation'=>'password',
        ];
    }
}
