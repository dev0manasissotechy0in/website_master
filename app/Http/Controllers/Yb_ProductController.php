<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductTags;

class Yb_ProductController extends Controller
{
    public function yb_index(){

    }

    public function yb_create(){
        $category = ProductCategory::where('status','1')->get();
        return view('public.create-product',compact('category'));
    }

    public function yb_store(Request $request){
        $request->validate([
            'product_name' => 'required|unique:products,title',
            'category' => 'required',
            'preview_link' => 'required',
            'download_file' => 'required|mimes:zip',
        ]);

        $slug = Str::slug($request->product_name);
        $exist = Product::where('slug',$slug)->pluck('id')->first();
        if($exist){
            $slug = $slug.rand(0,10);
        }

        if($request->thumb){
            $image = str_replace(' ','-',strtolower($request->product_name)).rand().$request->thumb->getClientOriginalName();
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
            $file = str_replace(' ','-',strtolower($request->product_name)).rand().'.'.$request->download_file->getClientOriginalExtension();
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
        $product->title = $request->product_name;
        $product->slug = $slug;
        $product->category = $request->category;
        $product->sub_category = $request->sub_category;
        $product->tags = implode(',',$t_arr);
        $product->thumbnail = $image;
        $product->images = implode(',',$images);
        $product->desc = htmlspecialchars($request->desc);
        $product->user = session()->get('user_sess');
        $product->preview_link = $request->preview_link;
        $product->download_file = $file;
        $product->status = '0';
        $save = $product->save();
        return $save;
    }

    public function yb_edit($slug){
        $product = Product::where('slug',$slug)->first();
        $tag_array = array_filter(explode(',',$product->tags));
        $tags = ProductTags::whereIn('id',$tag_array)->get();
        if($product){
            return view('public.edit-product',compact('product','tags'));
        }else{
            return abort('404');
        }
    }

    public function yb_update(Request $request,$slug){
        $request->validate([
            'preview_link' => 'required',
        ]);

        $product = Product::where('slug',$slug)->first();

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
        $product->tags = implode(',',$t_arr);
        $product->thumbnail = $image;
        $product->images = implode(',',$images);
        $product->desc = htmlspecialchars($request->desc);
        $product->preview_link = $request->preview_link;
        $product->download_file = $file_name;
        $product->status = $request->status;
        $update = $product->save();
        return $update;
    }


}
