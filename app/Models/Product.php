<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\User;
use App\Models\OrderProducts;
use App\Models\ProductTags;

class Product extends Model
{
    use HasFactory;

    public function cat_name(){
        return $this->hasOne(ProductCategory::class,'id','category');
    }

    public function subcat_name(){
        return $this->hasOne(ProductSubCategory::class,'id','sub_category');
    }

    public function author(){
        return $this->hasOne(User::class,'id','user');
    }

    public function downloads(){
        return $this->hasOne(OrderProducts::class,'product_id','id');
    }

    
    
}
