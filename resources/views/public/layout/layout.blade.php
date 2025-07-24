<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <title>@yield('title'){{site_name()}}</title>
    @yield('meta')
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/frontend/css/bootstrap.min.css')}}">
    <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{asset('public/frontend/css/image-uploader.css')}}" rel="stylesheet">
    @yield('pageStyleLinks')
    <link rel="stylesheet" href="{{asset('public/frontend/css/style.css')}}">
</head>
<body>
    <div id="wrapper">
        <header id="header">
            <div class="header-topbar">
                <div class="container d-flex justify-content-between">
                <ul class="header-social d-flex list-unstyled m-0">
                    @php $social_links = social_links(); @endphp
                    @foreach($social_links as $social)
                    <li><a href="{{$social->link}}" target="_blank"><i class="{{$social->icon}}"></i></a></li>
                    @endforeach
                </ul>
                <ul class="topbar-right d-flex list-unstyled m-0 align-self-center">
                    @if(session()->has('user_sess'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle p-0" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{url('user-profile')}}"><i class="bi bi-person"></i> My Profile</a></li>
                            @if(session()->get('user_type') == 'seller' && approved_seller())
                            <li><a class="dropdown-item" href="{{url('create-product')}}"><i class="bi bi-plus-square"></i> Add Product</a></li>
                            <li><a class="dropdown-item" href="{{url('my-products')}}"><i class="bi bi-boxes"></i> My Products</a></li>
                            <li><a class="dropdown-item" href="{{url('withdraw-requests')}}"><i class="bi bi-arrow-down-square"></i> Withdraw Request</a></li>
                            <li><a class="dropdown-item" href="{{url('seller-wallet')}}"><i class="bi bi-arrow-down-square"></i> My Wallet</a></li>
                            @endif
                            @if(session()->get('user_type') == 'user')
                            <li><a class="dropdown-item" href="{{url('my-downloads')}}"><i class="bi bi-download"></i> My Downloads</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{url('change-password')}}"><i class="bi bi-pencil"></i> Change Password</a></li>
                        </ul>
                    </li>
                    <li><a href="{{url('logout')}}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    @else
                    <li><a href="{{url('login')}}"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                    <li><a href="{{url('signup')}}"><i class="bi bi-person-add"></i> Register</a></li>
                    @endif
                </ul>
                </div>
            </div>
            <div class="logobar py-4">
                <div class="container d-flex justify-content-between">
                    <a href="{{url('/')}}" class="logo">
                        <img src="{{asset('public/settings/logo.png')}}" alt="">
                    </a>
                    <ul class="logobar-right d-flex list-unstyled m-0 align-self-center">
                        @if(!session()->has('user_type') || session()->get('user_type') != 'seller')
                        <li><a href="{{url('my-wishlist')}}"><i class="bi bi-heart-fill"></i><span class="count-badge">{{wishlist_count()}}</span></a></li>
                        <li><a href="{{url('my-cart')}}"><i class="bi bi-basket-fill"></i><span class="count-badge">{{cart_count()}}</span></a></li>
                        @endif
                        @if(session()->has('user_sess') != 'seller')
                        <li class="selling"><a href="{{url('seller-signup')}}"><i class="bi bi-plus"></i>Start Selling</a></li>
                        @endif
                        @if(session()->get('user_type') == 'seller' && approved_seller())
                        <li class="selling"><a href="{{url('create-product')}}">+ Add Product</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('blogs')}}">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('all-products')}}">Products</a>
                            </li>
                            @php $pages = custom_pages(); @endphp
                            @foreach($pages as $page)
                            @if($page->show_in_header == '1')
                            <li class="nav-item">
                                <a class="nav-link" href="{{url($page->slug)}}">{{$page->title}}</a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        @yield('content')
        <footer id="footer" class="pt-5">
            <div class="container">
                <div class="row">
                    @php $settings = settings(); @endphp
                    <div class="col-md-3">
                        <div class="footer-widget mb-5">
                            <h5>{{site_name()}}</h5>
                            <p>{{$settings->site_desc}}</p>
                            <ul class="footer-social">
                                @foreach($social_links as $social)
                                <li><a href="{{$social->link}}"><i class="{{$social->icon}}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget ps-4 mb-5">
                            <h5>Useful Links</h5>
                            <ul>
                                <li><a href="{{url('login')}}"><i class="bi bi-arrow-right-circle"></i> Login</a></li>
                                <li><a href="{{url('signup')}}"><i class="bi bi-arrow-right-circle"></i> Register</a></li>
                                @foreach($pages as $page)
                                @if($page->show_in_footer == '1')
                                <li><a href="{{url($page->slug)}}"><i class="bi bi-arrow-right-circle"></i> {{$page->title}}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget mb-5">
                            <h5>Categories</h5>
                            <ul>
                                @php $categories = product_categories();  @endphp
                                @foreach($categories as $cat)
                                <li><a href="{{url('product/c/'.$cat->slug)}}">{{$cat->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="footer-widget mb-5">
                            <h5>Contact</h5>
                            <ul class="contact-info">
                                @if($settings->show_contact == '1')
                                <li><i class="bi bi-telephone-fill"></i> {{$settings->site_contact}}</li>
                                @endif
                                @if($settings->show_email == '1')
                                <li><i class="bi bi-envelope"></i> {{$settings->site_email}}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center py-3">
                <span>{{copyright_text()}}</span>
            </div>
        </footer>
    </div>
    <script src="{{asset('public/frontend/js/bootstrap5.0.2.min.js')}}"></script>
    <input type="text" hidden class="site-url" value="{{url('/')}}">
    <script src="{{asset('public/frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
    <script src="{{asset('public/frontend/js/image-uploader.js')}}"></script>
    <script src="{{asset('public/frontend/js/action.js')}}"></script>
    @yield('pageJsScripts')
</body>
</html>