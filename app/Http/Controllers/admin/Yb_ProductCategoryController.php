<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class Yb_ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::withCount('products')->latest()->get();
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
                $btn = '<a href="'.url("admin/product-category/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger btn-sm rounded-pill deleteProductCategory" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('admin.product.category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:product_categories,name'
        ]);

        $slug = Str::slug($request->category_name);
        $exist = ProductCategory::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = new ProductCategory();
        $cat->name = $request->category_name;
        $cat->slug = $slug;
        $cat->page_title = ($request->seo_title != '') ? $request->seo_title : $request->category_name ;
        $cat->page_desc = $request->seo_desc;
        $save = $cat->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product.edit-category',compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'category_name' => 'required|unique:product_categories,name,'.$productCategory->id.',id'
        ]);

        $slug = Str::slug(($request->category_slug != '') ? $request->category_slug : $request->category_name);
        $exist = ProductCategory::where('slug',$slug)->whereNot('id',$productCategory->id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = ProductCategory::find($productCategory->id);
        $cat->name = $request->category_name;
        $cat->slug = $slug;
        $cat->page_title = ($request->seo_title != '') ? $request->seo_title : $request->category_name ;
        $cat->page_desc = $request->seo_desc;
        $cat->status = $request->status;
        $save = $cat->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $destroy = ProductCategory::where('id',$productCategory->id)->delete();
        return $destroy;
    }
}
