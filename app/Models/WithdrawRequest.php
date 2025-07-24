<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\WithdrawMethod;

class WithdrawRequest extends Model
{
    use HasFactory;

    public function seller(){
        return $this->hasOne(User::class,'id','seller_id');
    }

    public function method_name(){
        return $this->hasOne(WithdrawMethod::class,'id','method');
    }
}
