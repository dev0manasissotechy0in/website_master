@extends('public.layout.layout')
@section('title','My Cart : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') My Cart @endslot
@slot('active') My Cart @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($products->isNotEmpty())
                <form action="{{url('user/checkout')}}">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; $total = 0; @endphp
                        @foreach($products as $product)
                        @php $i++; $total += $product->price; @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                @if($product->image != '')
                                <img src="{{asset('public/products/default.jpg')}}" alt="" width="50px">
                                @else
                                <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="" width="50px">
                                @endif
                                <input type="text" hidden name="item[]" value="{{$product->id}}">
                            </td>
                            <td>{{$product->title}}</td>
                            <td>{{cur_format()}}{{$product->price}}</td>
                            <td>
                                <button type="button" data-id="{{$product->id}}" class="btn remove-cart"><i class="bi bi-x"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Grand Total</th>
                            <th>{{cur_format()}}{{$total}}</th>
                            <th colspan="2"></th>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between">
                    <a href="{{url('all-products')}}" class="btn">Continue Shopping</a>
                    <input type="submit" class="btn" value="Go To Checkout"/>
                </div>
                </form>
                @else
                <div class="text-center">
                    <h3>No Products Found in Cart</h3>
                    <a href="{{url('/')}}" class="btn">Add Products</a>
                </div>
                @endif
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