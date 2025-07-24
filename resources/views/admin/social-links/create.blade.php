@extends('admin.partials.layout')
@section('title','Add Social Links : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/css/bootstrapicons-iconpicker.min.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Social Links'=>'admin/social-links']])
        @slot('title') Create Social Links @endslot
        @slot('add_btn') @endslot
        @slot('active') Create @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="addSocialLink">
                          @csrf
                            <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Icon</label>
                                <input type="text" id="icon" class="form-control" name="icon" required>
                              </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Link</label>
                              <input type="text" class="form-control" name="link" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                              </select>
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
<script src="{{asset('public/assets/js/bootstrapicon-iconpicker.min.js')}}"></script>
<script>
    $(function() {
        $('#icon').iconpicker({
            search: true
        });
    })
</script>
@stop