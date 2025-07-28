@extends('public.layout.layout')
@section('title', $product->title . ' : ')

{{-- Meta Intigration --}}

@section('meta')
    {{-- Basic Meta Tags --}}
    <meta name="title" content="{{ $product->title }}">
    <meta name="description" content="{{ Str::limit(strip_tags($product->seo_description ?? $product->desc), 160) }}">
    {{-- <meta name="keywords" content="{{ implode(',', explode(',', $product->tags)) }}"> --}}
    <meta name="keywords" content="{{ $product->tag_list ?? '' }}">
    <meta name="author" content="{{ $product->author->name ?? 'Admin' }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="product">
    <meta property="og:title" content="{{ $product->title }}">
    <meta property="og:description"
        content="{{ Str::limit(strip_tags($product->seo_description ?? $product->desc), 160) }}">
    <meta property="og:image"
        content="{{ asset($product->thumbnail != '' ? 'public/products/' . $product->thumbnail : 'public/products/default.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $product->title }}">
    <meta name="twitter:description"
        content="{{ Str::limit(strip_tags($product->seo_description ?? $product->desc), 160) }}">
    <meta name="twitter:image"
        content="{{ asset($product->thumbnail != '' ? 'public/products/' . $product->thumbnail : 'public/products/default.png') }}">
@endsection

@section('pageStyleLinks')
    <link rel="stylesheet" href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css">
@endsection
@section('content')
    @php
        $breadcrumb = [];
        $breadcrumb['Home'] = '/';
        $breadcrumb[$product->cat_name->name] = url('product/c/' . $product->cat_name->slug);
        if ($product->subcat_name != null) {
            $breadcrumb[$product->subcat_name->name] = url(
                'product/c/' . $product->cat_name->slug . '/' . $product->subcat_name->slug,
            );
        }
    @endphp
    @component('public.layout.page-header', ['breadcrumb' => $breadcrumb])
        @slot('title')
            {{ $product->title }}
        @endslot
        @slot('active')
            {{ $product->title }}
        @endslot
    @endcomponent
    <section id="page-content" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @if ($product->thumbnail != '')
                        <img src="{{ asset('public/products/' . $product->thumbnail) }}" class="w-100 mb-3" alt="">
                    @else
                        <img src="{{ asset('public/products/default.png') }}" class="w-100 mb-3" alt="">
                    @endif
                    <ul class="list-unstyled d-flex justify-content-center">
                        @if ($product->preview_link != '')
                            <li class="me-3"><a href="{{ $product->preview_link }}" class="btn" target="_blank">Live
                                    Preview</a></li>
                        @endif
                        @if ($product->images != '')
                            <li class="me-3"><button type="button" id="show-screenshots"
                                    class="btn">Sreenshots</button></li>
                            @php
                                $images = array_filter(explode(',', $product->images));
                                $img_count = count($images);
                            @endphp
                            @if ($img_count > 0)
                                <div id="lightgallery" class="d-none">
                                    @for ($i = 0; $i < $img_count; $i++)
                                        <a href="{{ asset('public/products/' . $images[$i]) }}">
                                            <img src="{{ asset('public/products/' . $images[$i]) }}" />
                                        </a>
                                    @endfor
                                </div>
                            @endif
                        @endif
                        @if (session()->has('user_type') && session()->get('user_type') != 'seller')
                            @php$cart = user_cart();
                                                                                                                                                                                                                                                                                        $wishlist = user_wishlist(); @endphp ?> ?> ?> ?> ?> ?> ?> ?> ?>
                            @if (in_array($product->id, $cart))
                                <li class="me-3"><button data-id="{{ $product->id }}" class="remove-cart btn">Remove
                                        From Cart</button></li>
                            @else
                                <li class="me-3"><button data-id="{{ $product->id }}" class="add-cart btn">Add to
                                        Cart</button></li>
                            @endif
                            @if (in_array($product->id, $wishlist))
                                <li class="me-3"><button data-id="{{ $product->id }}" class="remove-wishlist btn">Remove
                                        from Wishlist</button></li>
                            @else
                                <li class="me-3"><button data-id="{{ $product->id }}" class="add-cart btn">Add to
                                        Wishlist</button></li>
                            @endif
                        @endif
                    </ul>
                    {!! htmlspecialchars_decode($product->desc) !!}
                    <div class="page-widget border p-4 mb-4">
                        <h4>Reviews</h4>
                        @foreach ($reviews as $review)
                            <div class="review-box border">
                                <div class="user-info d-flex mb-2">
                                    <div class="user-img">
                                        <img src="{{ asset('public/users/default.png') }}" alt="" width="50px">
                                    </div>
                                    <h6 class="align-self-center m-0">{{ $review->name }}</h6>
                                </div>
                                <ul class="rating d-flex list-unstyled mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li><i
                                                class="bi @if ($review->rating >= $i) bi-star-fill @else bi-star @endif"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <p>{{ htmlspecialchars_decode($review->feedback) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="page-widget border p-4 mb-4">
                        <h4>Product Information</h4>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <ul class="product-links d-flex list-unstyled">
                                    @if (!session()->has('user_type') || session()->get('user_type') != 'seller')
                                        @if (session()->has('user_sess'))
                                            @php $wishlist = user_cart(); @endphp
                                            <li class="@if (in_array($product->id, $wishlist)) active @endif">
                                                <a href="javascript:void(0);" data-id="{{ $product->id }}"
                                                    class="add-wishlist">
                                                    <i class="bi bi-heart-fill"></i>
                                                </a>
                                            </li>
                                        @else
                                            @php $cart = user_cart(); @endphp
                                            <li class="@if (in_array($product->id, $cart)) active @endif">
                                                <a href="javascript:void(0);" data-id="{{ $product->id }}"
                                                    class="add-cart"> <b>Buy Now: </b>
                                                    <i class="bi bi-basket-fill"></i>
                                                </a>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </li>

                            <li class="d-flex justify-content-between">
                                <span>Price: </span>
                                <span class="w-auto">{{ $product->price }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Last Update</span>
                                <span class="w-auto">{{ date('d M, Y', strtotime($product->updated_at)) }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Release Date</span>
                                <span class="w-auto">{{ date('d M, Y', strtotime($product->created_at)) }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Category</span>
                                <span class="w-auto">
                                    <a
                                        href="{{ url('product/c/' . $product->cat_name->slug) }}">{{ $product->cat_name->name }}</a>
                                    @if ($product->subcat_name != null)
                                        , <a
                                            href="{{ url('product/c/' . $product->cat_name->slug . '/' . $product->subcat_name->slug) }}">{{ $product->subcat_name->name }}</a>
                                    @endif
                                </span>
                            </li>

                            @if ($product->tags != '')
                                @php
                                    $tag_names = array_filter(explode(',', $product->tag_list));
                                    $tag_slugs = array_filter(explode(',', $product->tag_slugs));
                                    $count_tags = count($tag_names);
                                @endphp
                                <li class="d-flex justify-content-between">
                                    <span>Tags</span>
                                    <span class="w-auto">
                                        @for ($i = 0; $i < $count_tags; $i++)
                                            <a href="{{ url('product/tag/' . $tag_slugs[$i]) }}">{{ $tag_names[$i] }}</a>
                                            @if ($i < $count_tags - 1)
                                                ,
                                            @endif
                                        @endfor
                                    </span>
                                </li>
                            @endif

                        </ul>

                    </div>
                    <div class="page-side-widget text-center">
                        <div class="user-img rounded-circle overflow-hidden">
                            @if ($product->author->image != '')
                                <img src="{{ asset('public/users/' . $product->author->image) }}" alt="">
                            @else
                                <img src="{{ asset('public/users/default.png') }}" alt="">
                            @endif
                        </div>
                        <h4 class="user-name">{{ $product->author->name }}</h4>
                        <span>Member Since {{ date('M Y', strtotime($product->author->created_at)) }}</span>
                        <a href="{{ url('seller/' . $product->author->slug) }}" class="btn d-block">View Profile</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('pageJsScripts')
    <script src="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js"></script>
    <script>
        lightGallery(document.getElementById('lightgallery'));

        $("#show-screenshots").on("click", () => {
            $("#lightgallery a:first-child > img").trigger("click");
        });
    </script>
@endsection
