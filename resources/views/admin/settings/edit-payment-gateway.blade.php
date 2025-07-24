@extends('admin.partials.layout')
@section('title','Edit Payment Gateway : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Payment Gateways'=>'admin/payment-gateways']])
        @slot('title') Edit Payment Gateway @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updatePaymentGateway">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" value="{{$gateway->name}}" required>
                              <input type="text" hidden class="id" value="{{$gateway->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Image</label>
                              <input type="file" name="image" class="form-control" onChange="readURL(this);" />
                              @if($gateway->image != '')
                              <img id="image" src="{{asset('public/payment/'.$gateway->image)}}" width="100px">
                              @else
                              <img id="image" src="{{asset('public/payment/default.png')}}" width="100px">
                              @endif
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($gateway->status == '1') selected @endif>Active</option>
                                <option value="0" @if($gateway->status == '0') selected @endif>Inactive</option>
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
<script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    
</script>
@stop