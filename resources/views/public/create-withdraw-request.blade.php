@extends('public.layout.layout')
@section('title','New Withdraw Requests : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') New Withdraw Request @endslot
@slot('active') New Withdraw Requests @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form id="createWithdraw" class="border p-4 pt-5 position-relative" method="POST">
                    <h3>Submit New Withdraw Request</h3>
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Method</label>
                        <select name="method" class="form-control">
                            <option value="" selected disabled>Select Method</option>
                            @foreach($methods as $row)
                            <option value="{{$row->id}}">{{$row->name}}({{$row->charge}}%)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Amount</label>
                        <input type="number" name="amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <span>Available Balance : {{cur_format()}}{{seller_balance(session()->get('user_sess'))}}</span>
                    </div>
                    <input type="submit" class="btn" value="Submit">
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
<script src="{{asset('public/frontend/js/product.js')}}"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $(function(){
        $('.product-images').imageUploader({
            imagesInputName: 'images',
            'label': 'Drag & Drop files here or click to browse' 
        });
    })
</script>
@endsection