<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\Models\User;

class Yb_UserController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = User::where('type','user')->latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status',function($row){
                if($row->status == '1'){
                    return '<span class="text-success">Active</span>';
                }else{
                    return '<span class="text-danger">Inactive</span>';
                }
            })
            ->addColumn('action', function($row){
                if($row->status == '1'){
                    $btn = '<button class="btn btn-danger btn-sm rounded-pill blockUser" data-id="'.$row->id.'" data-status="'.$row->status.'"><i class="bi bi-eye-slash-fill"></i></button>';
                    }else{
                    $btn = '<button class="btn btn-success btn-sm rounded-pill blockUser" data-id="'.$row->id.'" data-status="'.$row->status.'"><i class="bi bi-eye-fill"></i></button>';
                    }
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('admin.users.index');
    }


    public function yb_sellers(Request $request){
        if ($request->ajax()) {
            $data = User::where('type','seller')->latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('name',function($row){
                return $row->name.' <small>('.$row->user_name.')</small>';
            })
            ->editColumn('status',function($row){
                if($row->status == '1'){
                    return '<span class="text-success">Active</span>';
                }else{
                    return '<span class="text-danger">Inactive</span>';
                }
            })
            ->editColumn('approved_seller',function($row){
                if($row->approved_seller == '1'){
                    return '<span class="text-success">Approved</span>';
                }else{
                    return '<button class="btn btn-sm btn-primary approveSeller" data-id="'.$row->id.'">Approve</button>';
                }
            })
            ->addColumn('action', function($row){
                if($row->status == '1'){
                $btn = '<button class="btn btn-danger btn-sm rounded-pill blockUser" data-id="'.$row->id.'" data-status="'.$row->status.'"><i class="bi bi-eye-slash-fill"></i></button>';
                }else{
                $btn = '<button class="btn btn-success btn-sm rounded-pill blockUser" data-id="'.$row->id.'" data-status="'.$row->status.'"><i class="bi bi-eye-fill"></i></button>';
                }
                return $btn;
            })
            ->rawColumns(['name','approved_seller','status','action'])
            ->make(true);
        }
        return view('admin.users.sellers');
    }

    public function yb_changeUser_status(Request $request){
        $id = $request->uId;
        $status = $request->status;
        $update = User::where('id',$id)->update([
            'status' => $status
        ]);
        return $update;
    }

    public function yb_approveSeller(Request $request){
        $id = $request->uId;
        $update = User::where('id',$id)->update([
            'approved_seller' => '1'
        ]);
        return $update;
    }
}
