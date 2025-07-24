@extends('admin.partials.layout')
@section('title','Product Sub Category : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Product Sub Category @endslot
        @slot('add_btn') <a href="{{url('admin/product-sub-category/create')}}" class="btn btn-primary btn-sm rounded-pill align-self-center">+ Add New</a>  @endslot
        @slot('active') Product Sub Category @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Name','Products','Parent Category','Status','Action']
                    ])
                        @slot('table_id') productSubCategory-list @endslot
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
    var table = $("#productSubCategory-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "product-sub-category",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'name', name: 'image'},
            {data: 'products_count', name: 'products_count',sWidth: '50px'},
            {data: 'parent_category', name: 'parent_category'},
            {data: 'status', name: 'status',sWidth: '50px'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop