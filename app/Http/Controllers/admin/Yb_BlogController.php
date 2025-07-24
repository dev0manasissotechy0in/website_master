<?php

namespace App\Http\Controllers\admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image as ResizeImage;

class Yb_BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('cat_name')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    if ($row->image != '') {
                        $image = '<img src="' . asset("public/blogs/" . $row->image) . '" width="50px"/>';
                    } else {
                        $image = '<img src="' . asset("public/blogs/default.png") . '" width="50px"/>';
                    }
                    return $image .= ' <span>' . substr($row->title, 0, 40) . '...</span>';
                })
                ->addColumn('category_name', function ($row) {
                    return $row->cat_name->name;
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == '1') {
                        return '<span class="text-success">Active</span>';
                    } else {
                        return '<span class="text-danger">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href="' . url("admin/blogs/" . $row->id . "/edit") . '" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm rounded-pill deleteBlog" data-id="' . $row->id . '"><i class="bi bi-trash"></i></button>';

                    return $btn;
                })
                ->rawColumns(['title', 'status', 'action'])
                ->make(true);
        }
        return view('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = BlogCategory::all();
        return view('admin.blog.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|unique:blogs,title',
            'category' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'seo_description' => 'required|unique:blogs,seo_description',
            'seo_keyword' => 'required'

        ]);

        $slug = Str::slug($request->blog_title);
        $exist = Blog::where('slug', $slug)->pluck('id')->first();
        if ($exist) {
            $slug = $slug . rand(0, 10);
        }

        if ($request->image) {
            $image = Str::slug($request->blog_title) . rand() . $request->image->getClientOriginalName();
            $request->image->move(public_path('blogs'), $image);
        } else {
            $image = "";
        }

        $blog = new Blog();
        $blog->title = $request->blog_title;
        $blog->slug = $slug;
        $blog->image = $image;
        $blog->category = $request->category;
        $blog->desc = htmlspecialchars($request->desc);
        $blog->seo_description = $request->seo_description;
        $blog->seo_keyword = $request->seo_keyword;
        $save = $blog->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $category = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'blog_title' => 'required|unique:blogs,title,' . $blog->id . ',id',
            'category' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'seo_description' => 'required|unique:blogs,seo_description,' . $blog->id . ',id',
            'seo_keyword' => 'required',
            'status' => 'required|in:0,1', //Status code update
        ]);

        $slug = Str::slug(($request->blog_slug != '') ? $request->blog_slug : $request->blog_title);
        $exist = Blog::where('slug', $slug)->whereNot('id', $blog->id)->pluck('id')->first();
        if ($exist) {
            $slug = $slug . rand(0, 10);
        }

        if ($request->image != '') {
            $path = public_path() . '/blogs/';
            //code for remove old file
            if ($request->old_img != '' && $request->old_img != null) {
                $file_old = $path . $request->old_img;
                if (file_exists($file_old)) {
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->image;
            $image = Str::slug($request->title) . rand() . $request->image->getClientOriginalName();
            $file->move($path, $image);
        } else {
            $image = $request->old_img;
        }

        $blog = Blog::find($blog->id);
        $blog->title = $request->blog_title;
        $blog->slug = $slug;
        $blog->image = $image;
        $blog->category = $request->category;
        $blog->desc = htmlspecialchars($request->desc);
        $blog->seo_description = $request->seo_description;
        $blog->seo_keyword = $request->seo_keyword;
        $blog->status = $request->status;   
        $save = $blog->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image != '') {
            $filePath = public_path() . '/blogs/' . $blog->image;
            File::delete($filePath);
        }
        $destroy = Blog::where('id', $blog->id)->delete();
        return $destroy;
    }
}
