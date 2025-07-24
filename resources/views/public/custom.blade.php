@extends('public.layout.layout')
@section('title',$page->title.' : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') {{$page->title}} @endslot
@slot('active') {{$page->title}} @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!!htmlspecialchars_decode($page->desc)!!}
            </div>
        </div>
    </div>
</section>
@endsection