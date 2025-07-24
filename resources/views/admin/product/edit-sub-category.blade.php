@extends('admin.partials.layout')
@section('title','Edit Product Sub Category : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Product Sub Category'=>'admin/product-sub-category']])
        @slot('title') Edit Product Sub Category @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateProductSubCategory">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" required value="{{$productSubCategory->name}}">
                              <input type="text" class="id" hidden value="{{$productSubCategory->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Slug</label>
                              <input type="text" class="form-control" name="slug" required value="{{$productSubCategory->slug}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Parent Category</label>
                              <select name="category" class="form-control">
                                <option value="" selected disabled>Select Parent Category</option>
                                @foreach($category as $cat)
                                @php $selected = ($cat->id == $productSubCategory->category) ? 'selected' : ''; @endphp
                                <option value="{{$cat->id}}" {{$selected}} >{{$cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Title</label>
                              <input type="text" class="form-control" value="{{$productSubCategory->page_title}}" name="seo_title">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Description</label>
                              <textarea name="seo_desc" value="{{$productSubCategory->page_desc}}" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($productSubCategory->status == '1') selected @endif >Active</option>
                                <option value="0" @if($productSubCategory->status == '0') selected @endif>Inactive</option>
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