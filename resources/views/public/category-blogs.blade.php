@extends('public.layout.layout')
@section('title',$cat_detail->page_title.' : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/','Blogs'=>'blogs']])
@slot('title') {{$cat_detail->name}} @endslot
@slot('active') {{$cat_detail->name}} @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-9 row">
            @foreach($blogs as $blog)
                @include('public.partials.blog',['blog'=>$blog])
            @endforeach
            </div>
            <div class="col-md-3">
                <div class="page-widget border p-4 mb-4">
                    <h4>Categories</h4>
                    <ul class="list-unstyled">
                        @foreach($category as $cat)
                        @if($cat->blogs_count > 0)
                        <li><a href="{{url('/blogs/c/'.$cat->slug)}}">{{$cat->name}}</a></li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection