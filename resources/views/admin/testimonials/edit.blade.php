@extends('admin.partials.layout')
@section('title','Edit Testimonials : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Testimonials'=>'admin/testimonials']])
        @slot('title') Edit Testimonial @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateTestimonial">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Client Name</label>
                              <input type="text" class="form-control" name="client_name" value="{{$testimonial->client_name}}" required>
                              <input type="text" class="id" hidden value="{{$testimonial->id}}" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Client Designation</label>
                              <input type="text" class="form-control" name="client_designation" value="{{$testimonial->client_designation}}" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Feedback</label>
                              <textarea name="feedback" class="form-control" required>{{$testimonial->client_feedback}}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Client Image</label>
                                <input type="file" class="form-control mb-2" name="image" onChange="readURL(this);">
                                @if($testimonial->client_image != '')
                                <img id="image" src="{{asset('public/testimonials/'.$testimonial->client_image)}}" width="100px">
                                @else
                                <img id="image" src="{{asset('public/testimonials/default.png')}}" width="100px">
                                @endif
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($testimonial->status == '1') selected @endif >Active</option>
                                <option value="0" @if($testimonial->status == '0') selected @endif>Inactive</option>
                              </select>
                            </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@stop
@section('pageJsScripts')
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop