@extends('public.layout.layout')
@section('title','My Wallet : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') My Wallet @endslot
@slot('active') My Wallet @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-widget">
                    <h4>Available Balance : {{cur_format()}}{{seller_balance(session()->get('user_sess'))}}</h4>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Date</th>
                            <th>Deposit</th>
                            <th>Withdraw</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 0; @endphp
                        @foreach($wallet as $row)
                        @php $i++; @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{date('d M, Y',strtotime($row->created_at))}}</td>
                            <td>@if($row->type == 'credit') 
                                {{cur_format()}}{{$row->amount}} @endif</td>
                            <td>@if($row->type == 'debit') {{cur_format()}} {{$row->amount}} @endif
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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