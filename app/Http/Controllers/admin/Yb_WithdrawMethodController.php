<?php

namespace App\Http\Controllers\admin;

use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class Yb_WithdrawMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WithdrawMethod::latest()->get();
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
                $btn = '<a href="'.url("admin/withdraw-methods/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger btn-sm rounded-pill deleteWithdrawMethod" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('admin.withdraw-method.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.withdraw-method.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:withdraw_methods,name',
            'charge' => 'required',
            'minimum_amount' => 'required',
            'maximum_amount' => 'required',
        ]);

        $method = new WithdrawMethod();
        $method->name = $request->name;
        $method->charge = $request->charge;
        $method->min_amount = $request->minimum_amount;
        $method->max_amount = $request->maximum_amount;
        $method->status = $request->status;
        $save = $method->save();
        return $save;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WithdrawMethod $withdrawMethod)
    {
        return view('admin.withdraw-method.edit',compact('withdrawMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WithdrawMethod $withdrawMethod)
    {
        $request->validate([
            'name' => 'required|unique:withdraw_methods,name,'.$withdrawMethod->id.',id',
            'charge' => 'required',
            'minimum_amount' => 'required',
            'maximum_amount' => 'required',
        ]);

        

        $method = WithdrawMethod::find($withdrawMethod->id);
        $method->name = $request->name;
        $method->charge = $request->charge;
        $method->min_amount = $request->minimum_amount;
        $method->max_amount = $request->maximum_amount;
        $method->status = $request->status;
        $save = $method->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WithdrawMethod $withdrawMethod)
    {
        $destroy = WithdrawMethod::where('id',$withdrawMethod->id)->delete();
        return $destroy;
    }
}
