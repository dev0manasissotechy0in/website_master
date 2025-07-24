<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Orders;
use App\Models\Product;

class Yb_AdminController extends Controller
{
    public function yb_index(Request $request){
        if($request->input()){
            $request->validate([
				'username'=>'required',
				'password'=>'required',
			]); 
			$login = DB::table('admin')->where(['username'=>$request->username])->pluck('password')->first();

			if(empty($login)){
				return response()->json(['username'=>'Username Does not Exists']);
			}else{
				if(Hash::check($request->password,$login)){
					$request->session()->put('exist_admin','1');
					return '1';
				}else{
					return response()->json(['password'=>'Username and Password does not matched']);
				}
			}
        }else{
            return view('admin.index');
        }
    }

    public function yb_logout(){
        Auth::logout();
		session()->forget('exist_admin');
		return '1';
    }

    public function yb_dashboard(){
		$today_sales = Orders::withCount('products')->whereDate('created_at',date('Y-m-d'))->count();
		$customers = User::whereYear('created_at',date('Y'))->where(['type'=>'user','status'=>'1'])->count();
		$products = Product::count();
		$orders = Orders::count();
        return view('admin.dashboard',compact('today_sales','customers','products','orders'));
    }

	public function yb_edit_profile(Request $request){
		$admin = DB::table('admin')->select('admin_name','username')->first();
		if($request->input()){
			$request->validate([
				'admin_name' => 'required',
				'username' => 'required',
			]);
			$update = DB::table('admin')->update([
				'admin_name' => $request->admin_name,
				'username' => $request->username,
			]);
			return $update;
		}else{
			return view('admin.edit-profile',compact('admin'));
		}
	}

	public function yb_update_password(Request $request){
		$request->validate([
			'current_password' => 'required',
			'new_password' => 'required',
			'confirm_password' => 'required',
		]);
		$get_admin = DB::table('admin')->first();

		if(Hash::check($request->current_password,$get_admin->password)){
			DB::table('admin')->update([
				'password'=>Hash::make($request->new_password)
			]);
			return '1';
		}else{
			return 'Please Enter Correct Current Password';
		}
	}
}
