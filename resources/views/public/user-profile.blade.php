@extends('public.layout.layout')
@section('title','Profile : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Profile @endslot
@slot('active') Profile @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="page-side-widget text-center">
                    <div class="user-img rounded-circle overflow-hidden">
                        @if($profile->image != '')
                        <img src="{{asset('public/users/'.$profile->image)}}" alt="">
                        @else
                        <img src="{{asset('public/users/default.png')}}" alt="">
                        @endif
                    </div>
                    <h4 class="user-name">{{$profile->name}}</h4>
                    <span>Member Since {{date('M Y',strtotime($profile->created_at))}}</span>
                    <a href="{{url('user/edit-profile')}}" class="btn d-block"><i class="bi bi-pencil"></i> Edit Profile</a>
                </div>
                <div class="page-widget border p-4 mb-4">
                    <h4>Contact Info</h4>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope"></i> {{$profile->email}}</li>
                        <li><i class="bi bi-phone"></i> {{$profile->phone}}</li>
                    </ul>
                </div>
                
            </div>
            <div class="col-md-9">
                @if($profile->type == 'seller' && $profile->approved_seller == '0')
                <div class="page-widget border p-2 mb-3 bg-danger text-white">
                    <h5 class="m-0">Your Selling Request in Progress.....</h5>
                </div>
                @elseif($profile->type == 'seller' && $profile->approved_seller == '1')
                <div class="page-widget border p-2 mb-3 bg-success text-white">
                    <h5 class="m-0">Your Selling Request is Approved</h5>
                </div>
                @endif
                <div class="page-widget border p-4 mb-3">
                    <h4>Personal Details</h4>
                    <ul class="list-unstyled">
                        <li><span>Full Name :</span> {{$profile->name}}</li>
                        <li><span>Location :</span> {{$profile->country}}</li>
                        <li><span>Email :</span> {{$profile->email}}</li>
                        <li><span>Phone :</span> {{$profile->phone}}</li>
                    </ul>
                </div>
                @if(session()->get('user_type') == 'seller')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card dashboard-card">
                                <i class="bi bi-cart"></i>
                                <h2 class="card-title">{{$total_sales}}</h2>
                                <span>Total Sales</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashboard-card">
                                <i class="bi bi-currency-dollar"></i>
                                <h2 class="card-title">{{$total_revenue*seller_commission()/100}}</h2>
                                <span>Total Revenue</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card dashboard-card">
                                <i class="bi bi-cart"></i>
                                <h2 class="card-title">{{$today_sales}}</h2>
                                <span>Today Sales</span>
                            </div>
                        </div>
                    </div>
                @else
                <div class="page-widget border p-3">
                    <h4 class="m-0 mb-3">My Downloads</h4>
                    <div class="row">
                        @if($products->isNotEmpty())
                            @foreach($products as $product)
                            <div class="col-md-4 mb-3">
                                @include('public.partials.product')
                            </div>
                            @endforeach
                        @else
                        <div class="col-12 text-center">
                            <h5>No Products Downloaded yet.</h5>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        
    </div>
</section>
@endsection