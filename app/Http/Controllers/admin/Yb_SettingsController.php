<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class Yb_SettingsController extends Controller
{
    public function yb_general_settings(Request $request){
        $general = DB::table('general_settings')->first();
        if($request->input()){
            // return $request->input();
            $request->validate([
                'website_name' => 'required',
                'website_email' => 'required',
                'website_contact' => 'required',
                'desc' => 'required',
                'currency_format' => 'required',
                'copyright_text' => 'required',
                'seo_title' => 'required',
            ]);

            if($request->logo != ''){        
                $path = public_path().'/settings/';
                //code for remove old file
                if($general->site_logo != ''  && $general->site_logo != null){
                    $file_old = $path.$general->site_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $request->logo;
                $image = rand().$request->logo->getClientOriginalName();
                $file->move($path, $image);
            }else{
                $image = $general->site_logo;
            }

            if($request->favicon != ''){        
                $path = public_path().'/settings/';
                //code for remove old file
                if($general->favicon != ''  && $general->favicon != null){
                    $file_old = $path.$general->favicon;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $request->favicon;
                $favicon = 'favicon'.$request->favion->getClientOriginalExension();
                $file->move($path, $favicon);
            }else{
                $favicon = $general->favicon;
            }

            if($request->show_contact){
                $show_contact = '1';
            }else{
                $show_contact = '0';
            }
            
            if($request->show_email){
                $show_email = '1';
            }else{
                $show_email = '0';
            }

            $update = Db::table('general_settings')->update([
                'site_name' => $request->website_name,
                'site_logo' => $image,
                'favicon' => $favicon,
                'site_email' => $request->website_email,
                'site_contact' => $request->website_contact,
                'address' => $request->address,
                'country' => $request->country,
                'site_desc' => $request->desc,
                'cur_format' => $request->currency_format,
                'copyright_txt' => $request->copyright_text,
                'show_contact' => $show_contact,
                'show_email' => $show_email,
                'site_seo_title' => $request->seo_title,
            ]);
            return $update;


        }else{
            
            return view('admin.settings.general',compact('general'));
        }
    }

    public function yb_payment_settings(Request $request){
        $payment = DB::table('payment_settings')->first();
        if($request->input()){
            $request->validate([
                'commission' => 'required',
                'tax_percent' => 'required',
            ]);
            DB::table('payment_settings')->update([
                'commission' => $request->commission,
                'tax_percent' => $request->tax_percent,
            ]);
            return '1';
        }else{
            return view('admin.settings.payment',compact('payment'));
        }
    }

    public function yb_payment_gateways(Request $request){
        if ($request->ajax()) {
            $data = DB::table('payment_gateways')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('image', function($row){
                        if($row->image != ''){
                            return '<img src="'.asset('public/payment/'.$row->image).'" width="100px">';
                        }else{
                            return '<img src="'.asset('public/payment/default.png').'" width="100px">';
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
       
                            $btn = '<a href="'.url("admin/payment-gateways/".$row->id."/edit").'" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                            ';
      
                            return $btn;
                    })
                    ->rawColumns(['image','status','action'])
                    ->make(true);
        }
        return view('admin.settings.payment-gateway');
    }

    public function yb_update_payment_gateways(Request $request,$id){
        $gateway = DB::table('payment_gateways')->where('id',$id)->first();
        if($request->input()){
            $request->validate([
                'name' => 'required|unique:payment_gateways,name,'.$id.',id'
            ]);

            if($request->image != ''){        
                $path = public_path().'/payment/';
                //code for remove old file
                if($gateway->image != ''  && $gateway->image != null){
                    $file_old = $path.$gateway->image;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $request->image;
                $image = rand().$request->image->getClientOriginalName();
                $file->move($path, $image);
            }else{
                $image = $gateway->image;
            }

            $update = DB::table('payment_gateways')->where('id',$id)->update([
                'name' => $request->name,
                'image' => $image,
                'status' => $request->status,
            ]);
            return $update;
        }else{
            
            return view('admin.settings.edit-payment-gateway',compact('gateway'));
        }
    }


    public function yb_homepage_settings(Request $request){
        if($request->input()){
            $update = DB::table('homepage_settings')->where('id',$request->id)->update([
                'section_title' => $request->section_title,
                'section_desc' => $request->section_desc,
                'status' => $request->status,
            ]);
            return $update;
        }else{
            $sections = DB::table('homepage_settings')->get();
            return view('admin.settings.homepage-settings',compact('sections'));
        }
    }


    public function yb_banner(Request $request){
        $banner = DB::table('banner')->first();
        if($request->input()){
            $request->validate([
                'title' => 'required'
            ]);

            if($request->image != ''){        
                $path = public_path().'/settings/';
                //code for remove old file
                if($banner->image != ''  && $banner->image != null){
                    $file_old = $path.$banner->image;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }
                //upload new file
                $file = $request->image;
                $image = rand().$request->image->getClientOriginalName();
                $file->move($path, $image);
            }else{
                $image = $banner->image;
            }

            $update = DB::table('banner')->update([
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'image' => $image,
            ]);
            return $update;
        }else{
            
            return view('admin.settings.banner',compact('banner'));
        }
    }
}
