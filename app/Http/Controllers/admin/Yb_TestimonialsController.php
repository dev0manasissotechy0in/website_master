<?php

namespace App\Http\Controllers\admin;

use App\Models\Testimonials;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class Yb_TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimonials::latest()->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="testimonials/'.$row->id.'/edit" class="btn btn-secondary btn-sm rounded-pill"><i class="bi bi-pencil-square"></i></a>
                <button class="btn btn-danger btn-sm rounded-pill deleteTestimonial" data-id="'.$row->id.'"><i class="bi bi-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->input();
        $request->validate([
            'client_name' => 'required|unique:testimonials,client_name',
            'client_designation' => 'required',
            'feedback' => 'required'
        ]);

        if($request->image){
            $image = str_replace(' ','-',strtolower($request->client_name)).rand().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('testimonials'),$image);
        }else {
            $image = "";
        }

        $test = new Testimonials();
        $test->client_name = $request->client_name;
        $test->client_designation = $request->client_designation;
        $test->client_feedback = $request->feedback;
        $test->client_image = $image;
        $test->status = $request->status;
        $save = $test->save();
        return $save;
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonials $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonials $testimonial)
    {
        return view('admin.testimonials.edit',compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonials $testimonial)
    {
        $request->validate([
            'client_name' => 'required|unique:testimonials,client_name,'.$testimonial->id.',id',
            'client_designation' => 'required',
            'feedback' => 'required'
        ]);

        if($request->image != ''){        
            $path = public_path().'/testimonials/';
            //code for remove old file
            if($testimonial->client_image != ''  && $testimonial->client_image != null){
                $file_old = $path.$testimonial->client_image;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->image;
            $image = str_replace(' ','-',strtolower($request->client_name)).rand().'.'.$request->image->getClientOriginalExtension();
            $file->move($path, $image);
        }else{
            $image = $testimonial->client_image;
        }

        $test = Testimonials::find($testimonial->id);
        $test->client_name = $request->client_name;
        $test->client_designation = $request->client_designation;
        $test->client_feedback = $request->feedback;
        $test->client_image = $image;
        $test->status = $request->status;
        $save = $test->save();
        return $save;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonials $testimonial)
    {
        if($testimonial->client_image != ''){
            $filePath = public_path().'/testimonials/'.$testimonial->client_image;
            File::delete($filePath);
        }
        return Testimonials::destroy($testimonial->id);
    }
}
