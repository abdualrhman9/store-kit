<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api')->only(['store','create']);
    }
    public function index(){
        $categories = Category::all();
        return response()->json([
            CategoryResource::collection($categories)
        ]);
    }

    public function store(Request $request){
        
        // dd($request->url());

        $rules = [
            'name'=>'required',
        ];


        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            // dd($validator->getMessageBag());
            return response()->json([
                'status'=>'error',
                'data'=>[
                    $validator->getMessageBag(),
                ]
            ]);
        }

        // dd($validator->getMessageBag());

        $category = Category::create([
            'name'=>$request->name
        ]);
        return response()->json(
            new CategoryResource($category)
        );
        
    }

    public function show(Category $category){
        return response()->json([
            new CategoryResource($category)
        ]);
    }
}
