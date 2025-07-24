@extends('admin.partials.layout')
@section('title','Dashboard : ')
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>[]])
        @slot('title') Dashboard @endslot
        @slot('add_btn')  @endslot
        @slot('active') Dashboard @endslot
    @endcomponent
    <section class="section dashboard">
        <div class="row">
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Sales <span>| Today</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$today_sales}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Orders <span>| All Orders</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$orders}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Customers <span>| This Year</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$customers}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-md-3">
                <div class="card info-card cart-card">
                    <div class="card-body">
                        <h5 class="card-title">Products <span>| All Products</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-list"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$products}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</main><!-- End #main -->
@stop