@extends('public.layout.layout')
@section('title','Signup Verification : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Email Verified @endslot
@slot('active') Email Verified @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h3>Email Verified Successfully!!.</h3>
            </div>
        </div>
    </div>
</section>
@endsection