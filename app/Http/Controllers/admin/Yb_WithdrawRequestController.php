<?php

namespace App\Http\Controllers\admin;

use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDO;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class Yb_WithdrawRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WithdrawRequest::with('method_name','seller')->latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('seller_name',function($row){
                return $row->seller->name;
            })
            ->addColumn('method_name',function($row){
                return $row->method_name->name;
            })
            ->editColumn('status',function($row){
                if($row->status == '1'){
                    return '<span class="text-success">Completed</span>';
                }elseif($row->status == '0'){
                    return '<span class="text-secondary">Pending</span>';
                }else{
                    return '<span class="text-danger">Rejected</span>';
                }
            })
            ->addColumn('action', function($row){
                if($row->status == '0'){
                $btn = '<button class="btn btn-success btn-sm rounded-pill changeRequestStatus" data-id="'.$row->id.'" data-status="1" >Approve</button>
                <button class="btn btn-danger btn-sm rounded-pill changeRequestStatus" data-id="'.$row->id.'" data-status="-1">Reject</button>';
                }else{
                    $btn = '';
                }
                return $btn;
            })
            ->rawColumns(['method_name','seller_name','status','action'])
            ->make(true);
        }
        return view('admin.withdraw-request.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WithdrawRequest $withdrawRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WithdrawRequest $withdrawRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WithdrawRequest $withdrawRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawRequest $withdrawRequest)
    {
        $destroy = WithdrawRequest::where('id',$withdrawRequest->id)->delete();
        return $destroy;
    }

    public function yb_changeStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        $req = WithdrawRequest::find($id);
        $req->status = $status;
        $update = $req->save();
        if($status == '1'){
            DB::table('seller_wallet')->insert([
                'seller_id' => $req->seller_id,
                'type' => 'debit',
                'amount' => ($req->amount-$req->charge_amount),
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s'),
            ]);
        }
        return $update;
    }
}
