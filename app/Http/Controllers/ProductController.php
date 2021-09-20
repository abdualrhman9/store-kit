<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{



    public function show(Product $product){
        return response()->json(new ProductResource($product));
    }

    public function store(Request $request){
        $rules = [
            'name'=>'required',
            'info'=>'required',
            'img_url'=>'required',
            'price'=>'required',
            'category_id'=>'required',
        ];
        
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status'=>'error',
                'data'=>[
                    $validator->getMessageBag(),
                ]
            ]);
        }
        
        try{
            
            $product = Product::create([
                'category_id'=>$request->category_id,
                'name'=>$request->name,
                'info'=>$request->info,
                'img_url'=>$request->img_url,
                'price'=>$request->price
            ]);
        }catch(\Illuminate\Database\QueryException $ex){
            dd($ex->getMessage());
            return response()->json([
                'status'=>'error',
                'data'=>[
                    'something went wrong'
                ]
            ]);
        }

        return response()->json(
            new ProductResource($product)
        );
    }
    
}
