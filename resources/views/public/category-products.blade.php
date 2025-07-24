@extends('public.layout.layout')
@section('title',$cat_detail->name.' : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/','Products'=>'all-products']])
@slot('title') {{$cat_detail->name}} @if(Request::get('s') != '') `Search : {{Request::get('s')}}` @endif @endslot
@slot('active') {{$cat_detail->name}} @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 row">
                @if($products->isNotEmpty())
                @foreach($products as $product)
                <div class="col-md-6">
                    @include('public.partials.product')
                </div>
                @endforeach
                @else
                <div class="page-widget border p-4">
                    <h4>No Products Found</h4>
                </div>
                @endif
            </div>
            <div class="col-md-3">
                <div class="page-widget border p-4 mb-4">
                    <h4>Search</h4>
                    <form action="{{url()->current()}}" class="row">
                        <div class="d-flex field-group position-relative">
                            <input type="text" class="form-control rounded-0" name="s" value="@if(Request::get('s') != ''){{Request::get('s')}} @endif"required >
                            <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                          </div>
                    </form>
                </div>
                <div class="page-widget border p-4 mb-4">
                    <h4>Sub Categories</h4>
                    <ul class="list-unstyled">
                        @foreach($sub_category as $cat)
                        @if($cat->products_count > 0)
                        <li><a href="{{url('/product/c/'.$cat_detail->slug.'/'.$cat->slug)}}">{{$cat->name}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                {{-- @endif --}}
                <div class="page-widget border p-4 mb-4">
                    <h4>Categories</h4>
                    <ul class="list-unstyled">
                        @foreach($category as $cat)
                        @if($cat->products_count > 0)
                        <li><a href="{{url('/product/c/'.$cat->slug)}}">{{$cat->name}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection