@extends('public.layout.layout')
@section('title','Payment Success : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Payment Success @endslot
@slot('active') payment success @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2 text-center">
                <h4>Payment Successfull</h4>
                <a href="{{url('my-downloads')}}" class="btn">Go To Downloads</a>
            </div>
        </div>
    </div>
</section>
@endsection