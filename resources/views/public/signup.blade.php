@extends('public.layout.layout')
@section('title','Signup : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Signup @endslot
@slot('active') signup @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="border p-4 pt-5 position-relative" id="user-register" method="POST">
                    <h3>Create Account!!!</h3>
                    @csrf
                    <div class="row">
                        <div class="form-group col-6 mb-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Unique Name</label>
                            <input type="text" class="form-control" name="unique_name" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Email Address</label>
                            <input type="email" class="form-control" name="email_address" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Password</label>
                            <input type="password" id="password" class="form-control" name="password" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm_password" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Country</label>
                            <input type="text" class="form-control" name="country" />
                        </div>
                        <input type="text" hidden name="type" value="user">
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Signup" />
                    </div>
                    <div class="text-center">
                        <span class="forgot-password"><a href="{{url('login')}}">Already have an account?</a></span>
                    </div>
                    
                </form>
                {{-- <div class="message"></div> --}}
            </div>
        </div>
    </div>
</section>
@endsection