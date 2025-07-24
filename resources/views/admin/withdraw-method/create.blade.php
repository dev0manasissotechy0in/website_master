@extends('admin.partials.layout')
@section('title','Create Withdraw Method : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/vendor/simple-datatables/style.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Withdraw Method'=>'admin/withdraw-methods']])
        @slot('title') Create Withdraw Method @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="addWithdrawMethod">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Charge (%)</label>
                              <input type="number" min="0" class="form-control" name="charge">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Minimum Amount</label>
                              <input type="number" min="0" class="form-control" name="minimum_amount">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Maximum Amount</label>
                              <input type="number" min="0" class="form-control" name="maximum_amount">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                              </select>
                            </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Submit</button>
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