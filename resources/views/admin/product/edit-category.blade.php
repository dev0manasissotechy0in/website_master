@extends('admin.partials.layout')
@section('title','Product Category : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/vendor/simple-datatables/style.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Product Category'=>'admin/product-category']])
        @slot('title') Edit Product Category @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="updateProductCategory">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="category_name" required value="{{$productCategory->name}}">
                              <input type="text" class="id" hidden value="{{$productCategory->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Slug</label>
                              <input type="text" class="form-control" name="category_slug" required value="{{$productCategory->slug}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Title</label>
                              <input type="text" class="form-control" value="{{$productCategory->page_title}}" name="seo_title">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Description</label>
                              <textarea name="seo_desc" class="form-control">{{$productCategory->page_desc}}</textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($productCategory->status == '1') selected @endif>Active</option>
                                <option value="0" @if($productCategory->status == '0') selected @endif>Inactive</option>
                              </select>
                            </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Update</button>
                            </div>
                          </form>
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
@stop