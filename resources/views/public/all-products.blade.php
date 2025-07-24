@extends('public.layout.layout')
@section('title','Products : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@if(Request::get('s') != '')
    @slot('title') Search : {{Request::get('s')}} @endslot
@else
    @slot('title') Products @endslot
@endif
@slot('active') Products @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 row">
                @if($products->total() > $products->perPage())
                <div class="col-12 page-widget border p-3 mb-4">
                    {{$products->links()}}
                </div>
                @endif
                @foreach($products as $product)
                <div class="col-md-6 mb-4">
                    @include('public.partials.product')
                </div>
                @endforeach
                @if($products->total() > $products->perPage())
                <div class="col-12 page-widget border p-3 mb-4">
                    {{$products->links()}}
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