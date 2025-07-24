@extends('public.layout.layout')
@section('title','Reset Password : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Change Password @endslot
@slot('active') Change Password @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form id="change-password" class="border p-4 pt-5 position-relative" method="POST">
                    @csrf
                    <h3>Change Password!!!</h3>
                    <div class="form-group mb-3">
                        <label for="">Current Password</label>
                        <input type="password" class="form-control" name="old_password" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="">New Password</label>
                        <input type="password" id="password" class="form-control" name="password" />
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" />
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection