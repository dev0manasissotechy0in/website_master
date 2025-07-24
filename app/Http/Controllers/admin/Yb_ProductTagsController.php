<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductTags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class Yb_ProductTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductTags::latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0);" class="btn btn-secondary btn-sm rounded-pill edit-productTag" data-id="'.$row->id.'"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger btn-sm rounded-pill deleteProductTag" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.product-tags.index');
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
        $request->validate([
            'tag_name' => 'required|unique:product_tags,name'
        ]);

        $slug = Str::slug($request->tag_name);
        $exist = ProductTags::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $tag = new ProductTags();
        $tag->name = $request->tag_name;
        $tag->slug = $slug;
        $tag->page_title = ($request->seo_title != '') ? $request->seo_title : $request->tag_name ;
        $tag->page_desc = $request->seo_desc;
        $save = $tag->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTags $productTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductTags $productTag)
    {
        return $productTag;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductTags $productTag)
    {
        $request->validate([
            'tag_name' => 'required|unique:product_tags,name,'.$productTag->id.',id',
            'tag_slug' => 'required'
        ]);

        $slug = Str::slug(($request->tag_slug != '') ? $request->tag_slug : $request->tag_name);
        $exist = ProductTags::where('slug',$slug)->whereNot('id',$productTag->id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $tag = ProductTags::find($productTag->id);
        $tag->name = $request->tag_name;
        $tag->slug = $slug;
        $tag->page_title = ($request->seo_title != '') ? $request->seo_title : $request->tag_name ;
        $tag->page_desc = $request->seo_desc;
        $save = $tag->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductTags $productTag)
    {
        return ProductTags::destroy($productTag->id);
    }
}
