@extends('admin.partials.layout')
@section('title','Product Sub Category : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Product Sub Category'=>'admin/product-sub-category']])
        @slot('title') Create Product Sub Category @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="addProductSubCategory">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Parent Category</label>
                              <select name="category" class="form-control">
                                <option value="" selected disabled>Select Parent Category</option>
                                @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Title</label>
                              <input type="text" class="form-control" name="seo_title">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Seo Description</label>
                              <textarea name="seo_desc" class="form-control"></textarea>
                            </div>
                            <div class="col-12">
                              <button class="btn btn-primary" type="submit">Submit</button>
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