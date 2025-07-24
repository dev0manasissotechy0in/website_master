@extends('public.layout.layout')
@section('title','Checkout : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Checkout @endslot
@slot('active') Checkout @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="checkout">
                <div class="page-widget border p-4 mb-3">
                    <h4>Products List</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; $total = 0; @endphp
                            @foreach($products as $product)
                            @php $i++; $total += $product->price; @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    @if($product->image != '')
                                    <img src="{{asset('public/products/default.jpg')}}" alt="" width="50px">
                                    @else
                                    <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="" width="50px">
                                    @endif
                                    <input type="text" hidden name="item[]" value="{{$product->id}}">
                                </td>
                                <td>{{$product->title}}</td>
                                
                                <td>{{cur_format()}}{{$product->price}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" align="right"><b>Total</b></td>
                                <th>{{cur_format()}}{{$total}}</th>
                            </tr>
                            @php  $tax_amt = ceil($total*tax_percent()/100); @endphp
                            <tr>
                                <td colspan="3" align="right">Tax({{tax_percent()}}%)</td>
                                <th>{{cur_format()}}{{$tax_amt}}</th>
                            </tr>
                            <tr>
                                <td colspan="3" align="right"><b>Grand Total</b></td>
                                <th>{{cur_format()}}{{$total+$tax_amt}}
                                <input type="text" hidden name="total_amount" class="total-amount" value="{{$total+$tax_amt}}"> 
                                <input type="text" hidden name="amount" value="{{$total}}"> 
                                <input type="text" hidden name="tax_amount" value="{{$tax_amt}}"> 
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="page-widget border p-4 mb-4">
                    <h4>Payment Method</h4>
                    <ul class="list-unstyled d-flex">
                        @php $gateways = payment_gateway_list();  @endphp
                        @foreach($gateways as $gateway)
                        <li class="me-4">
                            <input type="radio" id="pay{{$gateway->id}}" name="pay_method" value="{{$gateway->name}}" @if($gateway->name == 'razorpay') checked @endif required>
                            <label for="pay{{$gateway->id}}"><img src="{{asset('public/payment/'.$gateway->image)}}" width="100px"></label>
                            @if($gateway->name == 'razorpay')
                            <input type="text" hidden name="razor_key" value="{{env('RAZOR_KEY')}}">
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn confirm-order">Confirm Order</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
<script src="https://checkout.razorpay.com/v1/checkout.js" type="text/javascript"></script>
<script>
    // $('.confirm-order').click(function(){
    //     alert($('#checkout').serialize());
    // });
    $(function(){
        var uRL = $('.site-url').val();

          
            $(document).on('click','.confirm-order',function(){
                var amount = $('.total-amount').val();
                var method = $('input[name=pay_method]:checked').val();
                if(method == undefined || method == ''){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Select Payment Method',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }else{
                    if(method == 'paypal'){
                        var formdata = $('#checkout').serialize();
                        // console.log(formdata);
                        window.location.href = uRL+'/pay-with-paypal/?'+formdata;
                    }else{
                        var tr = '';
                        var razorpay = new Razorpay({
                            key: $('input[name=razor_key]').val(),
                            amount: amount*100, 
                            name: 'Digital Product Purchase',
                            order_id: '',
                            handler: function (transaction) {
                                tr = transaction.razorpay_payment_id;
                                var formdata = $('#checkout').serialize()+'&razor_payId='+tr;
                                window.location.href = uRL+'/pay-with-razorpay?'+formdata;
                            }
                        });
                        razorpay.open();
                    }
                }
                
            })
    });
</script>
@endsection