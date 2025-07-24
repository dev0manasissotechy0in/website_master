@extends('admin.partials.layout')
@section('title','Withdraw Requests : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Withdraw Requests @endslot
        @slot('add_btn')  @endslot
        @slot('active') Withdraw Requests @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Seller','Method','Amount','Charge','Status','Action']
                    ])
                        @slot('table_id') request-list @endslot
                    @endcomponent
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
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
{{-- <script src="{{asset('public/assets/vendor/simple-datatables/simple-datatables.js')}}"></script> --}}
<script type="text/javascript">
    var table = $("#request-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "withdraw-requests",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'seller_name', name: 'seller_name'},
            {data: 'method_name', name: 'method_name'},
            {data: 'amount', name: 'amount',sWidth: '50px'},
            {data: 'charge_amount', name: 'charge_amount',sWidth: '50px'},
            {data: 'status', name: 'status',sWidth: '50px'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '160px'
            }
        ]
    });
</script>
@stop