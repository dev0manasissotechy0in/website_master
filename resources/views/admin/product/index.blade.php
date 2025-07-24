@extends('admin.partials.layout')
@section('title','Products : ')
@section('pageStyleLinks')
{{-- <link rel="stylesheet" href="{{asset('public/assets/vendor/simple-datatables/style.css')}}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Products @endslot
        @slot('add_btn') <a href="{{url('admin/products/create')}}" class="btn btn-primary btn-sm rounded-pill align-self-center">+ Add New</a>  @endslot
        @slot('active') Products @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Title','Category','Price','Preview','Main File','Status','Approved','Action']
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
        ajax: "products",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'title', name: 'title'},
            {data: 'category_name', name: 'category'},
            {data: 'price', name: 'price'},
            {data: 'preview', name: 'preview'},
            {data: 'main_file', name: 'main_file'},
            {data: 'status', name: 'status'},
            {data: 'approved', name: 'approved'},
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