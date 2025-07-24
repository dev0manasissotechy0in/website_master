@extends('public.layout.layout')
@section('title','My Wishlist : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') My Wishlist @endslot
@slot('active') My Wishlist @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            @if($products->isNotEmpty())
            @foreach($products as $product)
                <div class="col-md-4">
                    @include('public.partials.product')
                </div>
            @endforeach
            @else
            <div class="col-md-12 text-center">
                <h3>No Products Found in wishlist</h3>
                @if(session()->has('user_sess'))
                <a href="{{url('/')}}" class="btn">Add Products to Wishlist</a>
                @else
                <a href="{{url('login')}}" class="btn">Add Products to Wishlist</a>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
<script src="{{asset('public/frontend/js/product.js')}}"></script>
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
        $('.product-images').imageUploader({
            imagesInputName: 'images',
            'label': 'Drag & Drop files here or click to browse' 
        });
    })
</script>
@endsection