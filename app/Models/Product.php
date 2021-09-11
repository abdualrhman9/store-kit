<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded =[];
    // protected $fillable = ['name','info','img_url','price','category_id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
