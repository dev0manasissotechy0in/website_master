@extends('public.layout.layout')
@section('title',$blog->title.' : ')

@section('meta')
    <meta name="title" content="{{ $blog->title }}">
    <meta property="og:image"
        content="{{ asset($blog->image != '' ? 'public/blogs/' . $blog->image : 'public/blogs/default.jpg') }}">
    <meta name="description" content="{{ Str::limit(strip_tags($blog->seo_description), 160) }}">
    <meta name="keywords" content="{{ implode(',', explode(' ', $blog->seo_keyword)) }}">
    
    <meta name="author" content="{{ $blog->author ?? 'Admin' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($blog->seo_description), 160) }}">
    <meta property="og:image"
        content="{{ asset($blog->image != '' ? 'public/blogs/' . $blog->image : 'public/blogs/default.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($blog->seo_description), 160) }}">
    <meta name="twitter:image"
        content="{{ asset($blog->image != '' ? 'public/blogs/' . $blog->image : 'public/blogs/default.png') }}">
@endsection

@section('content')
@php
$breadcrumb = [];
$breadcrumb['Home'] = url('/');
$breadcrumb['Blogs'] = url('blogs');
$breadcrumb[$blog->cat_name->name] = url('blogs/c/'.$blog->cat_name->slug);
@endphp
@component('public.layout.page-header',['breadcrumb'=>$breadcrumb])
@slot('title') {{$blog->title}} @endslot
@slot('active') {{$blog->title}} @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @if($blog->image != '')
                <img src="{{asset('public/blogs/'.$blog->image)}}" class="w-100 mb-3" alt="">
                @else
                <img src="{{asset('public/blogs/default.png')}}" class="w-100 mb-3" alt="">
                @endif
                {!!htmlspecialchars_decode($blog->desc)!!}
            </div>
            <div class="col-md-4">
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
                <div class="page-widget border p-4 mb-4">
                    <h4>Related</h4>
                    @foreach($related as $row)
                    <div class="post-box d-flex flex-row">
                        @if($row->image != '')
                            <img src="{{asset('public/blogs/'.$row->image)}}" alt="">
                        @else
                            <img src="{{asset('public/blogs/default.jpg')}}" alt="">
                        @endif
                        <div class="flex-grow-1">
                            <h5><a href="{{url('blog/'.$row->slug)}}">{{substr($row->title,0,40).'...'}}</a></h5>
                            <a href="{{url('blog/'.$row->slug)}}">Read More</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection