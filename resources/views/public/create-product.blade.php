@extends('public.layout.layout')
@section('title','Add Product : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
<!-- Tokenfield for Bootstrap-->
<link rel="stylesheet" href="{{asset('public/assets/css/tokenfield.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/trumbowyg.min.css')}}">
@stop
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Add Product @endslot
@slot('active') add product @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="add-product" class="border p-4 pt-5 position-relative" method="POST">
                    @csrf
                    <h3>Add New Product!!!</h3>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group mb-3">
                                <label for="">Product Title</label>
                                <input type="text" class="form-control" name="product_name" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <textarea name="desc" id="editor" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Images</label>
                                <div class="product-images"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Preview Link</label>
                                <input type="text" name="preview_link" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Downloadable File (zip file)</label>
                                <input type="file" name="download_file" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Tags</label>
                                <input type="text" name="tags" id="tokenfield" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="">Category</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach($category as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Sub Category</label>
                                <select name="sub_category" id="sub-category" class="form-control">
                                    <option value="" selected disabled>First Select Category</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Thumbnail</label>
                                <input type="file" class="form-control" name="thumb" onChange="readURL(this);" />
                                <img src="{{url('public/products/default.jpg')}}" id="image" class="w-100 mt-4" alt="">
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn" value="Submit" />
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
<script src="{{asset('public/frontend/js/product.js')}}"></script>
<!-- Tokenfield Js -->
<script src="{{asset('public/assets/js/tokenfield.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('public/frontend/js/trumbowyg.min.js')}}"></script>
<script>
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
        $('#editor').trumbowyg();

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
@endsection