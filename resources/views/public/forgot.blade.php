@extends('public.layout.layout')
@section('title','Forgot Password : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Forgot Password @endslot
@slot('active') forgot password @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form id="forgot-password" class="border p-4 pt-5 position-relative" method="POST">
                    @csrf
                    <h3>Forgot Password!!!</h3>
                    <div class="form- mb-3">
                        <label for="">Enter Your Email Address</label>
                        <input type="email" class="form-control" name="email" />
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Submit" />
                    </div>
                    <div class="text-center">
                        <span class="forgot-password"><a href="{{url('login')}}">Back to Login</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection