@extends('admin.partials.layout')
@section('title','Edit Product Review : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Product Reviews'=>'admin/product-reviews']])
        @slot('title') Edit Product Review @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateProductReview">
                          @csrf
                            <div class="mb-3">
                                <h5>Product : {{$review->title}}</h5>
                            </div>
                            <div class="mb-3">
                                <h5>User : {{$review->name}}</h5>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Rating</label>
                              <input type="number" class="form-control" name="rating" min="0" max="5" value="{{$review->rating}}" required>
                              <input type="text" hidden class="id" value="{{$review->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Feedback</label>
                              <textarea name="feedback" class="form-control">{{$review->feedback}}</textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($review->status == '1') selected @endif>Approve</option>
                                <option value="0" @if($review->status == '0') selected @endif>Pending</option>
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