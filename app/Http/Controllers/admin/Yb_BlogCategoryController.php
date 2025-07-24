<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Yb_BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::withCount('blogs')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="'.url("admin/blog-category/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm rounded-pill deleteBlogCategory" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.blog.category');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:blog_categories,name'
        ]);

        $slug = Str::slug($request->category_name);
        $exist = BlogCategory::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = new BlogCategory();
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = BlogCategory::where('id',$id)->first();
        return view('admin.blog.edit-category',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_name' => 'required|unique:blog_categories,name,'.$id.',id'
        ]);

        $slug = Str::slug(($request->category_slug != '') ? $request->category_slug : $request->category_name);
        $exist = BlogCategory::where('slug',$slug)->whereNot('id',$id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        $cat = BlogCategory::find($id);
        $cat->name = $request->category_name;
        $cat->slug = $slug;
        $cat->page_title = ($request->seo_title != '') ? $request->seo_title : $request->category_name ;
        $cat->page_desc = $request->seo_desc;
        $save = $cat->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $count = BlogCategory::withCount('blogs')->where('id',$id)->first();
        if($count->blogs_count < 1){
            $destroy = BlogCategory::where('id',$id)->delete();
            return $destroy;
        }else{
            return "You won't delete this category. This category used in Blogs.";
        }
    }
}
