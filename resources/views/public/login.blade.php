@extends('public.layout.layout')
@section('title','Login : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Login @endslot
@slot('active') login @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form id="user-login" class="border p-4 pt-5 position-relative" method="POST">
                    <h3>Welcome Back!!!</h3>
                    <div class="form- mb-3">
                        <label for="">Email Address</label>
                        <input type="email" class="form-control" name="email" />
                    </div>
                    <div class="form- mb-3">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" />
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Login" />
                        <span class="forgot-password align-self-center"><a href="{{url('forgot-password')}}">forgot password?</a></span>
                    </div>
                    <div class="text-center">
                        <span class="forgot-password"><a href="{{url('signup')}}">Don't have an account?</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection