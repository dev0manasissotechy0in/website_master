@extends('admin.partials.layout')
@section('title','Author Products : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Author Products @endslot
        @slot('add_btn')  @endslot
        @slot('active') Author Products @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Title','Category','Price','User','Preview','Main File','Approval','Status','Action']
                    ])
                        @slot('table_id') products-list @endslot
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
    var table = $("#products-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "author-products",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'title', name: 'title'},
            {data: 'category_name', name: 'category'},
            {data: 'price', name: 'price'},
            {data: 'user_name', name: 'user_name'},
            {data: 'preview', name: 'preview'},
            {data: 'main_file', name: 'main_file'},
            {data: 'approved', name: 'approved'},
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