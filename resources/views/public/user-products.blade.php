@extends('public.layout.layout')
@section('title','My Products : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') My Products @endslot
@slot('active') My Products @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="approve-tab" data-bs-toggle="tab" href="#approve-content" role="tab" aria-controls="approve-content" aria-selected="true">Approved</a
                      >
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="under-tab" data-bs-toggle="tab" href="#under-content" role="tab" aria-controls="under-content" aria-selected="false" >Under Approval</a
                      >
                    </li>
                </ul>
                <div class="tab-content" id="ex1-content">
                    <div class="tab-pane fade show active" id="approve-content" role="tabpanel" aria-labelledby="approve-tab" >
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Sales</th>
                                    <th>Approval Status</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->isNotEmpty())
                                @php $i=0; @endphp
                                @foreach($products as $product)
                                @if($product->approved == '1')
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        @if($product->image != '')
                                        <img src="{{asset('public/products/default.jpg')}}" alt="" width="50px">
                                        @else
                                        <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="" width="50px">
                                        @endif
                                    </td>
                                    <td>{{$product->title}}</td>
                                    <td>@if($product->price != '') {{cur_format()}}{{$product->price}}@endif</td>
                                    <td>{{$product->downloads_count}}</td>
                                    <td>
                                        <span class="text-success">Approved</span>
                                    </td>
                                    <td>
                                        @if($product->status == '1')
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="nav-link dropdown-toggle btn btn-primary btn-sm" href="#" id="mpDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="mpDropdown">
                                                <li><a class="dropdown-item" href="{{url('seller/'.$product->slug.'/edit-product')}}">Edit</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" align="center">No Products Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="under-content" role="tabpanel" aria-labelledby="under-tab">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Approval Status</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->isNotEmpty())
                                @php $i=0; @endphp
                                @foreach($products as $product)
                                @if($product->approved == '0')
                                @php $i++; @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        @if($product->image != '')
                                        <img src="{{asset('public/products/default.jpg')}}" alt="" width="50px">
                                        @else
                                        <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="" width="50px">
                                        @endif
                                    </td>
                                    <td>{{$product->title}}</td>
                                    <td>@if($product->price != '') ${{$product->price}}@endif</td>
                                    <td>
                                        <span class="text-secondary">Pending</span>
                                    <td>
                                        <span class="text-secondary">Inactive</span>
                                    </td>
                                    <td></td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" align="center">No Products Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                
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