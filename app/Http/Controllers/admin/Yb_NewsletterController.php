<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class Yb_NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('newsletter_subscribers')->orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('verified',function($row){
                if($row->id == '1'){
                    return '<span class="text-success">Verified</span>';
                }else{
                    return '<span class="text-danger">Not Verified</span>';
                }
            })
            ->addColumn('action', function($row){
                $btn = '<button class="btn btn-danger btn-sm rounded-pill deleteNewsletterEmail" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['verified','action'])
            ->make(true);
        }
        return view('admin.newsletter.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        return DB::table('newsletter_subscribers')->where('id',$id)->delete();
    }
}
