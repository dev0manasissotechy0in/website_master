<?php

namespace App\Http\Controllers\admin;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class Yb_OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Orders::with('order_user')->withCount('products')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('user_name',function($row){
                        return $row->order_user->name;
                    })
                    ->editColumn('status',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Completed</span>';
                        }else{
                            return '<span class="text-danger">Pending</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.url("admin/orders/".$row->id).'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-eye"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['user_name','status','action'])
                    ->make(true);
        }
        return view('admin.orders.index');
    }

    


    public function view($id)
    {
        $order = Orders::with('order_user','products')->where('id',$id)->first();
        return view('admin.orders.view',compact('order'));
    }

    
}
