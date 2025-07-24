<?php

namespace App\Http\Controllers\admin;

use App\Models\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class Yb_PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pages::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('show_in_header',function($row){
                        if($row->show_in_header == '1'){
                            $checked = 'checked';
                        }else{
                            $checked = '';
                        }
                        return '<div class="custom-checkbox">
                            <input type="checkbox" class="show-in-header" id="checkhead'.$row->id.'" '.$checked.'>
                            <label for="checkhead'.$row->id.'"></label>
                        </div>';
                    })
                    ->editColumn('show_in_footer',function($row){
                        if($row->show_in_footer == '1'){
                            $checked = 'checked';
                        }else{
                            $checked = '';
                        }
                        return '<div class="custom-checkbox">
                            <input type="checkbox" class="show-in-footer" id="checkfoot'.$row->id.'" '.$checked.'>
                            <label for="checkfoot'.$row->id.'"></label>
                        </div>';
                    })
                    ->editColumn('status',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Active</span>';
                        }else{
                            return '<span class="text-danger">Inactive</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.url("admin/pages/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm rounded-pill deletePage" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['show_in_header','show_in_footer','status','action'])
                    ->make(true);
        }
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_title' => 'required|unique:pages,title'
        ]);

        $slug = Str::slug($request->page_title);
        $exist = Pages::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $page = new Pages();
        $page->title = $request->page_title;
        $page->slug = $slug;
        $page->desc = htmlspecialchars($request->desc);
        $page->status = $request->status;
        $save = $page->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(Pages $pages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pages $page)
    {
        return view('admin.pages.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pages $page)
    {
        $request->validate([
            'page_title' => 'required|unique:pages,title,'.$page->id.',id'
        ]);

        $slug = Str::slug(($request->page_slug != '') ? $request->page_slug : $request->page_title);
        $exist = Pages::where('slug',$slug)->whereNot('id',$page->id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $page = Pages::find($page->id);
        $page->title = $request->page_title;
        $page->slug = $slug;
        $page->desc = htmlspecialchars($request->desc);
        $page->status = $request->status;
        $save = $page->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pages $page)
    {
        $destroy = Pages::where('id',$page->id)->delete();
        return $destroy;
    }

    public function yb_pageShow_inHeaderStatus(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Pages::where('id',$id)->update([
            'show_in_header'=> $status
        ]);
        return $response;
    }

    public function yb_pageShow_inFooterStatus(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Pages::where('id',$id)->update([
            'show_in_footer'=> $status
        ]);
        return $response;
    }
}
