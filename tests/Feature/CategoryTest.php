<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function name_field_is_required(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/categories',array_merge($this->getData(),['name'=>'']));
        $response->assertJson(
            [
                'status'=>'error',
                'data'=>[
                    [
                        'name'=>[
                            'The name field is required.'
                        ]
                    ]
                ]
            ]
        );
    }
    
    /** @test */
    public function category_can_be_add(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/categories',array_merge($this->getData()));

        $this->assertCount(1,Category::all());
        $response->assertJson([
            'status'=>'success',
            'data'=>[
                'categoryId'=> 1,
                'categoryName'=>'test name',
                'products'=>[]
            ]
        ]);
    }

    /** @test */
    public function list_of_categories_can_be_fetched(){
        $this->withoutExceptionHandling();
        $categories = Category::factory()->create();
        $response = $this->get('/api/categories?api_token='.$this->user->api_token);
        $response->assertJson([
            [
                [
                    'status'=>'success',
                    'data'=>[
                        'categoryId'=>$categories->first()->id,
                        'categoryName'=>$categories->first()->name,
                        'products'=>$categories->first()->products->toArray(),
                    ]
                ]
            ]
        ]);

    }





    private function getData(){
        return [
            'name' => 'test name',
            'api_token'=>$this->user->api_token
        ];
    }
}
