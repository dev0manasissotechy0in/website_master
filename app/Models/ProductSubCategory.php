<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSubCategory extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class,'sub_category','id');
    }

    public function parent_category(){
        return $this->hasOne(ProductCategory::class,'id','category');
    }
}
