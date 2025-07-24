@extends('admin.partials.layout')
@section('title','View Order : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Orders'=>'/admin/orders']])
        @slot('title') Order Detail @endslot
        @slot('add_btn') @endslot
        @slot('active') Order Detail @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body py-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Order No.</th>
                                <td>{{$order->id}}</td>
                            </tr>
                            <tr>
                                <th>Order Date</th>
                                <td>{{date('d M, Y',strtotime($order->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>Order User</th>
                                <td>{{$order->order_user->name}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Products</h5>
                    </div>
                    <div class="card-body py-4">
                        <table class="table table-bordered">
                            @foreach($order->products as $product)
                            <tr>
                                <td>{{$product->product_name->title}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Details</h5>
                    </div>
                    <div class="card-body py-4">
                        <table class="table table-bordered">
                            <tr>
                                <th>Payment ID</th>
                                <td>{{$order->pay_id}}</td>
                            </tr>
                            <tr>
                                <th>Payment Method</th>
                                <td>{{$order->pay_method}}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>{{cur_format()}}{{$order->amount}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
@stop
