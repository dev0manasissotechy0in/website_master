@extends('admin.partials.layout')
@section('title','Add New Product : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
<!-- Tokenfield for Bootstrap-->
<link rel="stylesheet" href="{{asset('public/assets/css/tokenfield.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/css/trumbowyg.min.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Products'=>'admin/products']])
        @slot('title') Create Product @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="addProduct">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="product_title" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Category</label>
                              <select name="category" id="category" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Sub Category</label>
                              <select name="sub_category" id="sub-category" class="form-control">
                                <option value="" selected disabled>First Select Category</option>
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Tags</label>
                              <input id="tokenfield" type="text" class="form-control" name="tags" placeholder="Type and hit enter to add a tag">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Price</label>
                              <input type="number" class="form-control" min="0" name="price" />
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Thumbnail</label>
                              <input type="file" name="thumb" class="form-control" onChange="readURL(this);" />
                              <img id="image" src="{{asset('public/products/default.jpg')}}" width="100px">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Images</label>
                              <div class="product-images"></div>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="tinymce-editor"></textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Preview Link</label>
                              <input type="text" class="form-control" name="preview_link" />
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Downloadable File (zip)</label>
                              <input type="file" name="download_file" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Featured</label>
                              <select name="featured" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0" selected>No</option>
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Approved</label>
                              <select name="approve" class="form-control">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                                <option value="2">Hide</option>
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
<!-- Tokenfield Js -->
<script src="{{asset('public/assets/js/tokenfield.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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

        $('#tokenfield').tokenfield({
        autocomplete: {
            delay: 100
        },
        showAutocompleteOnFocus: false
        });
    })
</script>
@stop