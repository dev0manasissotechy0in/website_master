@extends('public.layout.layout')
@section('title','')
@section('pageStyleLinks')

{{-- Fav Icon --}}

<link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
<link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

<link rel="stylesheet" href="{{asset('public/frontend/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/owl.theme.default.min.css')}}">
@endsection
@section('content')
<section id="banner-section" style="background-image: url('public/settings/{{$banner->image}}');">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="banner-content">
                    <h1>{{$banner->title}}</h1>
                    @if($banner->sub_title != '')
                    <h3>{{$banner->sub_title}}</h3>
                    @endif
                    <form action="{{url('search')}}" class="row">
                        <div class="d-flex field-group p-1 bg-white col-xl-8 mx-auto position-relative">
                            <input type="text" class="form-control search-input" name="s" required autocomplete="off" placeholder="Search Products">
                            <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                            <div class="search-autocomplete"></div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@foreach($home_sections as $section)
@if($section->section_name == 'Featured Products')
<section id="featured-section" class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="section-head">
                    <h2>{{$section->section_title}}</h2>
                    @if($section->section_desc != '')
                    <span>{{$section->section_desc}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="owl-carousel owl-theme featured-carousel">
            @foreach($featured as $product)
            <div class="item">
                @include('public.partials.product')
            </div>
            @endforeach
            {{-- <div class="col-12 text-center">
                <a href="{{url('/all-products')}}" class="btn">Show All</a>
            </div> --}}
        </div>
    </div>
</section>
@endif
@if($section->section_name == 'Latest Products')
<section id="latest-section" class="py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="section-head">
                    <h2>{{$section->section_title}}</h2>
                    @if($section->section_desc != '')
                    <span>{{$section->section_desc}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="owl-carousel owl-theme latest-carousel">
            @foreach($latest as $product)
            <div class="item">
                @include('public.partials.product')
            </div>
            @endforeach
            {{-- <div class="col-12 text-center">
                <a href="{{url('/all-products')}}" class="btn">Show All</a>
            </div> --}}
        </div>
    </div>
</section>
@endif
@if($section->section_name == 'Blog Section' && $blogs->isNotEmpty())
<section id="blog-section" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-head">
                    <h2>{{$section->section_title}}</h2>
                    @if($section->section_desc != '')
                    <span>{{$section->section_desc}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($blogs as $blog)
                @include('public.partials.blog',['blog'=>$blog])
            @endforeach
            <div class="col-12 text-center">
                <a href="{{url('blogs')}}" class="btn">Show All</a>
            </div>
        </div>
    </div>
</section>
@endif
@if($section->section_name == 'Newsletter')
<section id="newsletter-section" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="newsletter-content text-center">
                    <i class="far fa-envelope"></i>
                    <h3>{{$section->section_title}}</h3>
                    @if($section->section_desc != '')
                    <p>{{$section->section_desc}}</p>
                    @endif
                    <div class="form-group d-flex">
                        <input type="email" class="form-control news-email" required/>
                        <button class="btn subscribe-now">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@endforeach
<section id="testimonial-section" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-head">
                    <h2>Testimonials</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="testimonial-slider" class="owl-carousel owl-theme">
                    @foreach($testimonials as $feedback)
                    <div class="testimonial">
                        <p class="description">
                            <i class="bi bi-quote"></i>
                            {{$feedback->client_feedback}}
                        </p>
                        <div class="testimonial-content d-flex justify-content-center">
                            <div class="pic">
                                @if($feedback->client_image != '')
                                <img src="{{asset('public/testimonials/'.$feedback->client_image)}}">
                                @else
                                <img src="{{asset('public/testimonials/default.png')}}">
                                @endif
                            </div>
                            <div class="justify-content-start align-self-center">
                                <h3 class="title">{{$feedback->client_name}}</h3>
                                <span>{{$feedback->client_designation}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
<script src="{{asset('public/frontend/js/owl.carousel.min.js')}}"></script>
<script>
    $('.latest-carousel').owlCarousel({
        loop:false,
        margin:15,
        nav:true,
        dots:false,
        responsive:{
            0:{ items:1 },
            500:{ items:2 },
            700:{ items:3 },
            1000:{ items:4 },
            1200:{ items:5 }
        }
    })

    $('.featured-carousel').owlCarousel({
        loop:false,
        margin:15,
        nav:true,
        dots:false,
        responsive:{
            0:{ items:1 },
            500:{ items:2 },
            700:{ items:3 },
            1200:{ items:4 }
        }
    })

    $("#testimonial-slider").owlCarousel({
        loop:false,
        margin:0,
        nav:false,
        dots:true,
        responsive:{
            0:{ items:1 },
            500:{ items:1 },
            700:{ items:2 },
            1200:{ items:2 }
        }
    });
</script>
@endsection