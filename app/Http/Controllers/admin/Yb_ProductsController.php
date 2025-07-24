<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductTags;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class Yb_ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('cat_name')->where('user','1')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('title',function($row){
                        if($row->featured == '1'){
                        return '<span class="badge bg-success">$</span> '.substr($row->title,0,50).'....';
                        }else{
                            return substr($row->title,0,50).'....';
                        }
                    })
                    ->addColumn('category_name',function($row){
                        return $row->cat_name->name;
                    })
                    ->addColumn('preview',function($row){
                        return '<a class="btn btn-sm btn-primary" href="'.$row->preview_link.'"><i class="bi bi-arrow-up"></i></a>';
                    })
                    ->addColumn('main_file',function($row){
                        return '<a class="btn btn-sm btn-success" href="'.$row->preview_link.'"><i class="bi bi-download"></i></a>';
                    })
                    ->editColumn('approved',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Approved</span> ';
                        }else{
                            return '<span class="text-secondary">Pending</span>';
                        }
                    })
                    ->editColumn('status',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Active</span>';
                        }else{
                            return '<span class="text-danger">Inactive</span>';
                        }
                    })
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="'.url("admin/products/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-danger btn-sm rounded-pill deleteProduct" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
      
                            return $btn;
                    })
                    ->rawColumns(['title','status','preview','main_file','approved','action'])
                    ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = ProductCategory::where('status','1')->get();
        return view('admin.product.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_title' => 'required|unique:products,title',
            'category' => 'required',
            'price' => 'required',
            'download_file' => 'required|mimes:zip',
        ]);

        $slug = Str::slug($request->product_title);
        $exist = Product::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        if($request->thumb){
            $image = str_replace(' ','-',strtolower($request->product_title)).rand().$request->thumb->getClientOriginalName();
            $request->thumb->move(public_path('products'),$image);
        }else {
            $image = "";
        }

        $images = [];
        if($request->hasfile('images')){
            foreach($request->file('images') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('products'), $name);
                $images[] = $name;
            }
        }

        if($request->download_file){
            $file = str_replace(' ','-',strtolower($request->product_title)).rand().'.'.$request->download_file->getClientOriginalExtension();
            $request->download_file->move(public_path('downloadable'),$file);
        }else {
            $file = "";
        }
        
        $tags = explode(',',$request->tags);
        $t_arr = [];
        for($i=0; $i < count($tags); $i++){
            $tag_name = trim($tags[$i]);
            $tag_id = ProductTags::where('name',$tag_name)->pluck('id')->first();
            if($tag_id && $tag_id != ''){
                array_push($t_arr,$tag_id);
                $tag_id = null;
            }else{  
                $tag = new ProductTags();
                $tag->name = $tags[$i];
                $tag->slug = Str::slug($tags[$i]);
                $tag->page_title = $tags[$i];
                $res = $tag->save();
                array_push($t_arr,$tag->id);
            }
            $tag_id = null;
        }
        

        $product = new Product();
        $product->title = $request->product_title;
        $product->slug = $slug;
        $product->category = $request->category;
        $product->sub_category = $request->sub_category;
        $product->tags = implode(',',$t_arr);
        $product->price = $request->price;
        $product->thumbnail = $image;
        $product->preview_link = $request->preview_link;
        $product->download_file = $file;
        $product->images = implode(',',$images);
        $product->desc = htmlspecialchars($request->desc);
        $product->user = '1';
        $product->approved = '1';
        $product->featured = $request->featured;
        $product->status = $request->status;
        $save = $product->save();
        return $save;

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $category = ProductCategory::where('status','1')->get();
        $sub_category = ProductSubCategory::where(['category'=>$product->category,'status'=>'1'])->get();
        $tags = ProductTags::all();
        return view('admin.product.edit',compact('product','category','sub_category','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
      //  return $request->input();
        $request->validate([
            'product_title' => 'required|unique:products,title,'.$product->id.',id',
            'category' => 'required',
            'price' => 'required',
            'preview_link' => 'required',
        ]);

        $slug = Str::slug(($request->product_slug != '') ? $request->product_slug : $request->product_title);
        $exist = Product::where('slug',$slug)->whereNot('id',$product->id)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        if($request->thumb != ''){        
            $path = public_path().'/products/';
            //code for remove old file
            if($product->thumbnail != ''  && $product->thumbnail != null){
                $file_old = $path.$product->thumbnail;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->thumb;
            $image = str_replace(' ','-',strtolower($request->product_title)).rand().$request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $product->thumbnail;
        }

        $images = array_filter(explode(',',$product->images));
        if(!empty($request->old)){
            for($j=0;$j<count($images);$j++){
                if(!in_array($j+1,$request->old)){
                    $img = $images[$j];
                    if(file_exists(public_path('products/'.$img))){
                        unlink(public_path('products/').$img);
                    }
                    unset($images[$j]);
                }
            }
        }
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('products'), $name);
                $images[] = $name;
            }
        }

        if($request->download_file != ''){        
            $path = public_path().'/downloadable/';
            //code for remove old file
            if($product->download_file != ''  && $product->download_file != null){
                $file_old = $path.$product->download_file;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->download_file;
            $file_name = str_replace(' ','-',strtolower($request->product_title)).rand().'.'.$request->download_file->getClientOriginalExtension();
            $file->move($path, $file_name);
        }else{
            $file_name = $product->download_file;
        }
        
        $tags = explode(',',$request->tags);
        $t_arr = [];
        for($i=0; $i < count($tags); $i++){
            $tag_name = trim($tags[$i]);
            $tag_id = ProductTags::where('name',$tag_name)->pluck('id')->first();
            if($tag_id && $tag_id != ''){
                array_push($t_arr,$tag_id);
                $tag_id = null;
            }else{  
                $tag = new ProductTags();
                $tag->name = $tags[$i];
                $tag->slug = Str::slug($tags[$i]);
                $tag->page_title = $tags[$i];
                $res = $tag->save();
                array_push($t_arr,$tag->id);
            }
            $tag_id = null;
        }

        $product = Product::find($product->id);
        $product->title = $request->product_title;
        $product->slug = $slug;
        $product->category = $request->category;
        $product->sub_category = $request->sub_category;
        $product->tags = implode(',',$t_arr);
        $product->price = $request->price;
        $product->thumbnail = $image;
        $product->images = implode(',',$images);
        $product->desc = htmlspecialchars($request->desc);
        $product->preview_link = $request->preview_link;
        $product->download_file = $file_name;
        $product->approved = $request->approve;
        $product->featured = $request->featured;
        $product->status = $request->status;
        $save = $product->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->thumbnail != ''){
            $filePath = public_path().'/products/'.$product->thumbnail;
            File::delete($filePath);
        }   
        if($product->images != ''){
            $images = array_filter(explode(',',$product->images));
            $count = count($images);
            for($i=0;$i<$count;$i++){
                $filePath = public_path().'/products/'.$images[$i];
                File::delete($filePath);
            }
        }
        $destroy = Product::where('id',$product->id)->delete();
        return $destroy;
    }


    public function yb_author_products(Request $request){
        if ($request->ajax()) {
            $data = Product::with('cat_name','author')->where('user','!=','1')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('title',function($row){
                        if($row->featured == '1'){
                        return '<span class="badge bg-success">$</span>'.substr($row->title,0,50).'....';
                        }else{
                            return substr($row->title,0,50).'....';
                        }
                    })
                    ->addColumn('category_name',function($row){
                        return $row->cat_name->name;
                    })
                    ->addColumn('user_name',function($row){
                        return $row->author->name;
                    })
                    ->addColumn('preview',function($row){
                        return '<a class="btn btn-sm btn-primary" href="'.$row->preview_link.'"><i class="bi bi-arrow-up"></i></a>';
                    })
                    ->addColumn('main_file',function($row){
                        return '<a class="btn btn-sm btn-success" href="'.$row->preview_link.'"><i class="bi bi-download"></i></a>';
                    })
                    ->editColumn('approved',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Approved</span> ';
                        }else{
                            return '<span class="text-secondary">Pending</span>';
                        }
                    })
                    ->editColumn('status',function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Active</span>';
                        }else{
                            return '<span class="text-danger">Inactive</span>';
                        }
                    })
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="'.url("admin/products/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-eye"></i></a>
                            <button class="btn btn-danger btn-sm rounded-pill deleteProduct" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
      
                            return $btn;
                    })
                    ->rawColumns(['title','approved','status','preview','main_file','action'])
                    ->make(true);
        }
        return view('admin.product.author-products');
    }

    public function yb_get_category_sub_categories(Request $request){
        return get_cat_sub_categories($request->cat);
    }

    public function yb_product_reviews(Request $request){
        if ($request->ajax()) {
            $data = DB::table('reviews')->select(['reviews.*','products.title','users.name'])
            ->leftJoin('products','products.id','=','reviews.product_id')
            ->leftJoin('users','users.id','=','reviews.user_id')
            ->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('status', function($row){
                        if($row->status == '1'){
                            return '<span class="text-success">Approved</span>';
                        }else{
                            return '<span class="text-secondary">Pending</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.url("admin/product-reviews/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-danger btn-sm rounded-pill deleteProductReview" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['status','action'])
                    ->make(true);
        }
        return view('admin.reviews.index');
    }

    public function yb_edit_product_review(Request $request,$id)
    {
        if($request->input()){
            $request->validate([
                'rating' => 'required',
                'feedback' => 'required',
                'status' => 'required',
            ]);
            $update = DB::table('reviews')->where('id',$id)->update([
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'status' => $request->status,
            ]);
            return $update;
        }else{
            $review = DB::table('reviews')
            ->select(['reviews.*','products.title','users.name'])
            ->leftJoin('products','products.id','=','reviews.product_id')
            ->leftJoin('users','users.id','=','reviews.user_id')
            ->where('reviews.id',$id)->first();
            return view('admin.reviews.edit',compact('review'));
        }
    }

    public function yb_delete_review($id)
    {
        $destroy = DB::table('reviews')->where('id',$id)->delete();
        return $destroy;
    }
}
