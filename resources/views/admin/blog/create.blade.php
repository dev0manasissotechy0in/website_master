@extends('admin.partials.layout')
@section('title', 'Create Blog : ')
@section('pageStyleLinks')
@stop
@section('content')
    <main id="main" class="main">
        @component('admin.partials.page-head', [
            'breadcrumb' => ['Dashboard' => '/admin/dashboard', 'Blogs' => 'admin/blogs'],
        ])
            @slot('title')
                Create Blog
            @endslot
            @slot('add_btn')
            @endslot
            @slot('active')
                Create
            @endslot
        @endcomponent
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body py-3">
                            {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                            <form class="g-3 needs-validation" id="addBlog">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="blog_title" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Image (Size : 580px X 300px)</label>
                                    <input type="file" class="form-control mb-2" name="image"
                                        onChange="readURL(this);">
                                    <img id="image" src="{{ asset('public/blogs/default.jpg') }}" width="100px">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-control">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="desc" class="tinymce-editor"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">SEO Description</label>
                                    <input type="text" class="form-control" name="seo_description" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">SEO KEYWORD</label>
                                    <input type="text" class="form-control" name="seo_keyword" required>
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
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.validate.min.js') }}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>
@stop
