@extends('admin.partials.layout')
@section('title','Product Tags : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.css" />
@stop 
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Product Tags @endslot
        @slot('add_btn') <a href="javascript:void(0);" class="btn btn-primary btn-sm rounded-pill align-self-center" data-bs-toggle="modal" data-bs-target="#addModal">+ Add New</a>  @endslot
        @slot('active') Product Tags @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-4">
                        <!-- show data table component -->
                    @component('admin.partials.dataTables',['thead'=>
                        ['S NO.','Name','Action']
                    ])
                        @slot('table_id') productTags-list @endslot
                    @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" id="addProductTag">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addModalLabel">Add New Product Tag</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="">Name</label>
            <input type="text" class="form-control" name="tag_name">
          </div>
          <div class="form-group mb-3">
            <label for="">Seo Title</label>
            <input type="text" class="form-control" name="seo_title">
          </div>
          <div class="form-group mb-3">
            <label for="">Seo Description</label>
            <textarea name="seo_desc" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Submit">
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </form>
    </div>
  </div>
  {{-- add modal --}}
<div class="modal fade" id="updateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" method="POST" id="updateProductTag">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="updateModalLabel">Edit Product Tag</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @csrf
            {{ method_field('PUT') }}
          <div class="form-group mb-3">
            <label for="">Name</label>
            <input type="text" class="form-control" name="tag_name" value="">
            <input type="text" class="id" hidden value="">
          </div>
          <div class="form-group mb-3">
            <label for="">Slug</label>
            <input type="text" class="form-control" name="tag_slug" value="">
          </div>
          <div class="form-group mb-3">
            <label for="">Seo Title</label>
            <input type="text" class="form-control" name="seo_title" value="">
          </div>
          <div class="form-group mb-3">
            <label for="">Seo Description</label>
            <textarea name="seo_desc" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" class="btn btn-primary" value="Update">
        </div>
      </form>
    </div>
  </div>
@stop
@section('pageJsScripts')
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/1.13.8/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#productTags-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "product-tags",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '50px'},
            {data: 'name', name: 'image'},
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