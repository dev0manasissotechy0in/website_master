<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class OrderProducts extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    public function product_name(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
