@extends('admin.partials.layout')
@section('title','Add New Testimonials : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Testimonials'=>'admin/testimonials']])
        @slot('title') Create Testimonial @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="addTestimonial">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Client Name</label>
                              <input type="text" class="form-control" name="client_name" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Client Designation</label>
                              <input type="text" class="form-control" name="client_designation" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Feedback</label>
                              <textarea name="feedback" class="form-control" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Client Image</label>
                                <input type="file" class="form-control mb-2" name="image" onChange="readURL(this);">
                                <img id="image" src="{{asset('public/testimonials/default.png')}}" width="100px">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                              </select>
                            </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Submit</button>
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