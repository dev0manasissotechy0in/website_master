@extends('admin.partials.layout')
@section('title','Orders : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Orders @endslot
        @slot('add_btn')  @endslot
        @slot('active') Orders @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Order No.','User','Products','Amount','Status','Action']
                    ])
                        @slot('table_id') orders-list @endslot
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
    var table = $("#orders-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "orders",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'id', name: 'id'},
            {data: 'user_name', name: 'user_name'},
            {data: 'products_count', name: 'products_count'},
            {data: 'amount', name: 'amount'},
            {data: 'status', name: 'status'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '50px'
            }
        ]
    });
</script>
@stop