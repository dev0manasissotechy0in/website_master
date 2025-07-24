@extends('admin.partials.layout')
@section('title','Add New Page : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Pages'=>'admin/pages']])
        @slot('title') Create Page @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="addPage">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="page_title" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="tinymce-editor"></textarea>
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
    $(function(){
        $('.product-images').imageUploader({
            imagesInputName: 'images',
            'label': 'Drag & Drop files here or click to browse' 
        });
    })
</script>
@stop