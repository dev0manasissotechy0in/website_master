@extends('admin.partials.layout')
@section('title','Banner : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Banner @endslot
        @slot('add_btn') @endslot
        @slot('active') Banner @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateBanner">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="title" value="{{$banner->title}}" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Sub-Title</label>
                              <input type="text" class="form-control" name="sub_title" value="{{$banner->sub_title}}" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Image</label>
                              <input type="file" name="image" class="form-control" onChange="readURL(this);" />
                              @if($banner->image != '')
                              <img id="image" class="mt-3" src="{{asset('public/settings/'.$banner->image)}}" width="100px">
                              @else
                              <img id="image" class="mt-3" src="{{asset('public/settings/default.jpg')}}" width="100px">
                              @endif
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