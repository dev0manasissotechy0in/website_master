@extends('admin.partials.layout')
@section('title','General Settings : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Account Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Account Settings @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateAccountSettings">
                          @csrf
                          <div class="row">
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Admin Name</label>
                              <input type="text" class="form-control" name="admin_name" required value="{{$admin->admin_name}}">
                            </div>
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Username</label>
                              <input type="text" class="form-control" name="username" required value="{{$admin->username}}">
                            </div>
                          </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                          </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updatePasswordSettings">
                          @csrf
                          <div class="row">
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Current Password</label>
                              <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">New Password</label>
                              <input type="password" id="password" class="form-control" name="new_password" required>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Confirm New Password</label>
                              <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                          </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@stop
@section('pageJsScripts')
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
@stop