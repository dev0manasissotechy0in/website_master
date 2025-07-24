@extends('public.layout.layout')
@section('title',$user->name.' Products : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/','Products'=>'all-products']])
@slot('title') {{$user->name}} Products @endslot
@slot('active') {{$user->name}} Products @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="page-side-widget text-center">
                    <div class="user-img rounded-circle overflow-hidden">
                        @if($user->image != '')
                        <img src="{{asset('public/users/'.$user->image)}}" alt="">
                        @else
                        <img src="{{asset('public/users/default.png')}}" alt="">
                        @endif
                    </div>
                    <h4 class="user-name">{{$user->name}}</h4>
                    <span>Member Since {{date('M Y',strtotime($user->created_at))}}</span>
                </div>
                <div class="page-widget border p-4 mb-4">
                    <h4>Contact Info</h4>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope"></i> {{$user->email}}</li>
                        <li><i class="bi bi-phone"></i> {{$user->phone}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="page-widget border p-3">
                    <div class="row">
                        @if($products->isNotEmpty())
                        @foreach($products as $product)
                            <div class="col-md-6 mb-3">
                                @include('public.partials.product')
                            </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <h4>No Products Added yet.</h4>
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</section>
@endsection