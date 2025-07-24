@extends('admin.partials.layout')
@section('title','Edit Blog : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Blogs'=>'admin/blogs']])
        @slot('title') Edit Blog @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        {{-- <h5 class="card-title">Custom Styled Validation</h5> --}}
                        <form class="g-3 needs-validation" id="updateBlog">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="blog_title" required value="{{$blog->title}}">
                              <input type="text" class="id" value="{{$blog->id}}" hidden>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Slug</label>
                              <input type="text" class="form-control" name="blog_slug" required value="{{$blog->slug}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Image</label>
                              <input type="text" hidden name="old_img" value="{{$blog->image}}">
                              <input type="file" class="form-control mb-2" name="image" onChange="readURL(this);">
                              @if($blog->image != '')
                                <img id="image" src="{{asset('public/blogs/'.$blog->image)}}" width="100px">
                            @else
                                <img id="image" src="{{asset('public/blogs/default.jpg')}}" width="100px">
                              @endif
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Category</label>
                              <select name="category" class="form-control">
                                <option value="" disabled>Select Category</option>
                                @foreach($category as $row)
                                @php $selected = ($row->id == $blog->category) ? 'selected' : ''; @endphp
                                <option value="{{$row->id}}" {{$selected}} >{{$row->name}}</option>
                                @endforeach 
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="tinymce-editor">{!!$blog->desc!!}</textarea>
                            </div>
                                                        <!--Official-->
                                                        <div class="form-group mb-3">
                              <label class="form-label">SEO Description</label>
                              <input type="text" class="form-control" name="seo_description" required value="{{$blog->seo_description}}">
                              <input type="text" class="id" value="{{$blog->id}}" hidden>
                            </div>
                            
                                                        <div class="form-group mb-3">
                              <label class="form-label">SEO KEYWORD</label>
                              <input type="text" class="form-control" name="seo_keyword" required value="{{$blog->seo_keyword}}">
                              <input type="text" class="id" value="{{$blog->id}}" hidden>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($blog->status == '1') selected @endif>Active</option>
                                <option value="0" @if($blog->status == '0') selected @endif>Inactive</option>
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