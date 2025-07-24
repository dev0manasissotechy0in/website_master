@extends('public.layout.layout')
@section('title',$tag_detail->name.' : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/','Products'=>'all-products']])
@slot('title') #{{$tag_detail->name}} @endslot
@slot('active') {{$tag_detail->name}} @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 row">
                @foreach($products as $product)
                <div class="col-md-6">
                    @include('public.partials.product')
                </div>
                @endforeach
            </div>
            <div class="col-md-3">
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