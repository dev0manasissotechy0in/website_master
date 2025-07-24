@extends('public.layout.layout')
@section('title','Payment Failed : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Payment Failed @endslot
@slot('active') payment failed @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h4>Payment Failed</h4>
                <a href="{{url('/my-cart')}}" class="btn">Try Again</a>
            </div>
        </div>
    </div>
</section>
@endsection