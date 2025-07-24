<?php

namespace App\Http\Controllers\admin;

use App\Models\SocialLinks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Yb_SocialLinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SocialLinks::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="'.url("admin/social-links/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm rounded-pill deleteSocialLink" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.social-links.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.social-links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->input([
            'name' => 'required|unique:social_links,name',
            'icon' => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);

        $social = new SocialLinks();
        $social->name = $request->name;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->status = $request->status;
        $save = $social->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialLinks $socialLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialLinks $socialLink)
    {
        return view('admin.social-links.edit',compact('socialLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialLinks $socialLink)
    {
        $request->input([
            'name' => 'required|unique:social_links,name,'.$socialLink->id.',id',
            'icon' => 'required',
            'link' => 'required',
            'status' => 'required',
        ]);

        $social = SocialLinks::find($socialLink->id);
        $social->name = $request->name;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->status = $request->status;
        $save = $social->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialLinks $socialLink)
    {
        $destroy = SocialLinks::destroy($socialLink->id);
        return $destroy;
    }
}
