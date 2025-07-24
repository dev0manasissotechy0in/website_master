@extends('public.layout.layout')
@section('title','Signup Verification : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Signup Verification @endslot
@slot('active') signup verification @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form class="border p-4 pt-5 position-relative" id="signup-verify" method="POST">
                    <h3>Enter OTP!!!</h3>
                    <span class="mb-3 d-block">OTP sent to : <b>{{$email}}</b></span>
                    <span class="mb-3 d-block">Due to server load, OTP delivery might be slightly delayed. Kindly wait a moment</span>
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Enter OTP</label>
                        <input type="number" class="form-control" name="otp" />
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection