@extends('admin.partials.layout')
@section('title','Payment Settings : ')
@section('pageStyleLinks')
<style>
  .custom-checkbox{
    /* display: inline-block; */
    /* vertical-align: bottom; */
    position: relative; 
  }
  .custom-checkbox input[type=checkbox]{
      margin: 0;
      visibility: hidden;
      position: absolute;
      left: 1px;
      top: 1px;
  }
  .custom-checkbox label{
      width: 66px;
      height: 24px;
      border: 2px solid #706d92;
      cursor: pointer;
      border-radius: 10px;
      overflow: hidden;
      display: block;
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
  }
  .custom-checkbox label:before{
      content: '';
      background: #706d92;
      border-radius: 50px;
      width: 16px;
      height: 16px;
      position: absolute;
      bottom: 2px;
      left: 2px;
      transition: all 0.3s ease;
  }
  .custom-checkbox label:after{
    content: 'hide';
    color: '706d92';
    font-size: 14px;
    font-weight: 700;
    text-transform: capitalize;
    position: absolute;
    left: 22px;
    top: 0;
  }
  .custom-checkbox input[type=checkbox]:checked+label{
      background: #7338ba;
      border: 2px solid #7338ba;
  }
  .custom-checkbox input[type=checkbox]:checked+label:before{
      background: #fff;
      left: 44px;
  }

  .custom-checkbox input[type=checkbox]:checked+label:after{
    content: 'Show';
    color: #fff;
    left: 2px;
  }

  @media only screen and (max-width:767px){
      .custom-checkbox{ margin: 0 0 20px; }
  }
</style>
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Payment Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Payment Settings @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updatePaymentSettings">
                          @csrf
                          <div class="row">
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Commission (in %)</label>
                              <input type="number" class="form-control" name="commission" required value="{{$payment->commission}}">
                            </div>
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Tax Percentage (in %)</label>
                              <input type="number" class="form-control" name="tax_percent" required value="{{$payment->tax_percent}}">
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