<?php

namespace App\Http\Controllers\admin;

use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class Yb_ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = ProductSubCategory::with('parent_category')->withCount('products')->latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('parent_category',function($row){
                return $row->parent_category->name;
            })
            ->editColumn('status',function($row){
                if($row->status == '1'){
                    return '<span class="text-success">Active</span>';
                }else{
                    return '<span class="text-danger">Inactive</span>';
                }
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.url("admin/product-sub-category/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger btn-sm rounded-pill deleteProductSubCategory" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('admin.product.sub-category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::all();
        return view('admin.product.create-sub-category',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_sub_categories,name'
        ]);

        $slug = Str::slug($request->name);
        $exist = ProductSubCategory::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = new ProductSubCategory();
        $cat->name = $request->name;
        $cat->category = $request->category;
        $cat->slug = $slug;
        $cat->page_title = ($request->seo_title != '') ? $request->seo_title : $request->name ;
        $cat->page_desc = $request->seo_desc;
        $save = $cat->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubCategory $productSubCategory)
    {
        $category = ProductCategory::all();
        return view('admin.product.edit-sub-category',compact('category','productSubCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSubCategory $productSubCategory)
    {
        $request->validate([
            'name' => 'required|unique:product_sub_categories,name,'.$productSubCategory->id.',id'
        ]);

        $slug = Str::slug(($request->slug != '') ? $request->slug : $request->name);
        $exist = ProductSubCategory::where('slug',$slug)->whereNot('id',$productSubCategory->id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = ProductSubCategory::find($productSubCategory->id);
        $cat->name = $request->name;
        $cat->category = $request->category;
        $cat->slug = $slug;
        $cat->page_title = ($request->seo_title != '') ? $request->seo_title : $request->name ;
        $cat->page_desc = $request->seo_desc;
        $cat->status = $request->status;
        $save = $cat->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubCategory $productSubCategory)
    {
        $check = Product::where('sub_category',$productSubCategory->id)->count();
        if($check == 0){
            return $destroy = ProductSubCategory::destroy($productSubCategory->id);
        }else{
            return "You won't delete this sub category. This sub category is used in Products.";
        }
    }
}
