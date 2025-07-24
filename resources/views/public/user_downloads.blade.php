@extends('public.layout.layout')
@section('title','My Downloads : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') My Downloads @endslot
@slot('active') My Downloads @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @foreach($products as $product)
                <div class="product-single d-flex">
                    @if($product->thumbnail != '')
                    <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="">
                    @else
                    <img src="{{asset('public/products/default.png')}}" alt="">
                    @endif
                    <div class="product-content flex-grow-1">
                        <h3><a href="{{url('product/'.$product->slug)}}">{{$product->title}}</a></h3>
                        <span>Price : {{cur_format()}}{{$product->price}}</span>
                        <ul class="rating d-flex list-unstyled mb-0">
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star-fill"></i></li>
                            <li><i class="bi bi-star"></i></li>
                        </ul>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="{{url('product/'.$product->slug.'/download')}}" class="btn mb-2"><i class="bi bi-download"></i> Download</a>
                        <a href="{{url('product/'.$product->slug.'/reviews')}}" class="btn"><i class="bi bi-star"></i> Review</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                {{$products->links()}}
            </div>
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