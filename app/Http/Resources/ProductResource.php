<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'status'=>'success',
            'data'=>[
                'productId'=>$this->id,
                'productName'=>$this->name,
                'productInfo'=>$this->info,
                'productImg'=>$this->img_url,
                'categoryId'=>$this->category_id,
            ]
        ];
    }
}
