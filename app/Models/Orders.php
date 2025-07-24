<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderProducts;

class Orders extends Model
{
    use HasFactory;

    public function order_user(){
        return $this->hasOne(User::class,'id','user');
    }

    public function products(){
        return $this->hasMany(OrderProducts::class,'order_id','id')->with('product_name');
    }
}
