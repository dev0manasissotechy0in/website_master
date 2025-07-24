@extends('public.layout.layout')
@section('title','Withdraw Requests : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Withdraw Requests @endslot
@slot('active') Withdraw Requests @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{url('withdraw-requests/new')}}" class="btn mb-3">Make New Request</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Request No.</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Charge</th>
                            <th>Final Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($requests as $row)
                        @php $i++; @endphp
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->method_name->name}}</td>
                            <td>{{$row->amount}}</td>
                            <td>{{$row->charge_amount}}</td>
                            <td>{{$row->amount - $row->charge_amount}}</td>
                            <td>
                                @if($row->status == '1')
                                    <span class="text-success">Completed</span>
                                @else
                                    <span class="text-danger">Pending</span>
                                @endif
                            </td>
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