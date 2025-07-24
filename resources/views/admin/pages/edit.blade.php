@extends('admin.partials.layout')
@section('title','Edit Page : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Pages'=>'admin/pages']])
        @slot('title') Edit Page @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="updatePage">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="page_title" required value="{{$page->title}}">
                              <input type="text" hidden class="id" value="{{$page->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Slug</label>
                              <input type="text" class="form-control" name="page_slug" required value="{{$page->slug}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="tinymce-editor">{!!$page->desc!!}</textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($page->status == '1') selected @endif >Active</option>
                                <option value="0" @if($page->status == '0') selected @endif>Inactive</option>
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