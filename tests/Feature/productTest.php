<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class productTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $category;
    protected $product;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->product = Product::factory()->create();
        
    }

    /** @test */
    public function get_all_products(){
        $response = $this->get('/api/products?api_token='.$this->user->api_token);
        // dd($this->product);
        $response->assertJson([
            [
                'status'=>"success",
                'data'=>[
                    
                    'productId'=>$this->product->id,
                    'productName'=>$this->product->name,
                    'productInfo'=>$this->product->info,
                    'productImg'=>$this->product->img_url,
                    'categoryId'=>$this->product->category_id,
                
                ]
            ]
        ]);
        // dd($response->g);
        // return $response->g;
    }
    
    /** @test */
    public function product_fields_are_required(){
        $this->withoutExceptionHandling();
        $fields = collect([
            'name',
            'info',
            'price',
            // 'category_id',
            // 'img_url'
        ]);
        $fields->each(function($field){
            $response = $this->post('/api/products',array_merge($this->getData(),[$field=>'']));
            $response->assertJson([
                'status'=>'error',
                'data'=>[
                    [
                        $field => ["The $field field is required."]
                    ]
                ]

            ]);
        });

    }

    /** @test */
    public function product_can_be_add(){
        $this->withoutExceptionHandling();
        $response = $this->post('/api/products',array_merge($this->getData()));
        
        $this->assertCount(1,Product::all());

    }

    /** @test */
    public function product_can_be_fetched(){
        $product = Product::factory()->create();
        $response = $this->get('/api/products/'.$product->id);
        $response->assertJson([
            'status'=>'success',
            'data'=>[
                'productId'=>$product->id,
                'productName'=>$product->name,
                'productInfo'=>$product->info,
                'productImg'=>$product->img_url,
                'categoryId'=>$product->category_id,
            ]
        ]);
    }

    private function getData(){
        
        $data = [
            'name'=>'product name',
            'info' => 'very cool information',
            'price'=>12.99,
            'img_url'=>'some_img.jpg',
            'category_id'=>$this->category->id,
            'api_token'=>$this->user->api_token,
        ];

        return $data;

    }
}
