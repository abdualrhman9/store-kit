<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

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


    /** @test */
    public function login_user_test(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/login',['email'=>$this->user->email,'password'=>'password']);
        $response->assertJson(
            [
                'status'=>'success',
                'data'=>[
                    'name'=>$this->user->name,
                    'email'=>$this->user->email,
                    'api_token'=>$this->user->api_token,
                ]
            ]
        );
    }

    /** @test */
    public function login_user_wrong_credintals_test(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/login',['email'=>$this->user->email,'password'=>'passwordpassword']);
        $response->assertJson(
            [
                'status'=>'fail',
                'data'=>'No User Match '
            ]
        );
    }

    /** @test */
    public function user_update(){
        // $this->withoutExceptionHandling();
        // $user = User::factory()->create();
        $response = $this->patch('/api/users/'.$this->user->id,['name'=>'john doe','email'=>$this->user->email]);
        $response->assertJson([
            
            'name'=>'john doe',
            'email'=>$this->user->email
            
        ]);
        assertTrue($this->user->name !== User::first()->name);
    }


    private function getData(){
        return [
            'name'=>'John Doe',
            'email'=>'JohnDoe@test.com',
            'password'=>'23456789',
            'password_confirmation'=>'23456789',
        ];
    }
}
