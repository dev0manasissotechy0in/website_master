@extends('admin.partials.layout')
@section('title','Edit Withdraw Method : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/vendor/simple-datatables/style.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Withdraw Method'=>'admin/withdraw-methods']])
        @slot('title') Edit Withdraw Method @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateWithdrawMethod">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" value="{{$withdrawMethod->name}}"  required>
                              <input type="text" class="id" hidden value="{{$withdrawMethod->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Charge (%)</label>
                              <input type="number" min="0" class="form-control" name="charge" value="{{$withdrawMethod->charge}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Minimum Amount</label>
                              <input type="number" min="0" class="form-control" name="minimum_amount" value="{{$withdrawMethod->min_amount}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Maximum Amount</label>
                              <input type="number" min="0" class="form-control" name="maximum_amount" value="{{$withdrawMethod->max_amount}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($withdrawMethod->status == '1') selected @endif>Active</option>
                                <option value="0" @if($withdrawMethod->status == '0') selected @endif>Inactive</option>
                              </select>
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