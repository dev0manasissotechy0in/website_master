@extends('admin.partials.layout')
@section('title','Edit Homepage Section : ')
@section('pageStyleLinks')
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') Homepage Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') Homepage Settings @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        
                          <div class="accordion" id="accordions">
                            @foreach($sections as $section)
                            <div class="accordion-item mb-3">
                              <h2 class="accordion-header" id="section{{$section->id}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$section->id}}" aria-expanded="true" aria-controls="collapse{{$section->id}}">
                                  <b>{{$section->section_name}}</b>
                                </button>
                              </h2>
                              <div id="collapse{{$section->id}}" class="accordion-collapse collapse show bg-secondary-subtle" aria-labelledby="section{{$section->id}}" data-bs-parent="#accordions">
                                <div class="accordion-body">
                                  <form class="g-3 needs-validation" method="POST" id="homeSection{{$section->id}}">
                                    @csrf
                                    <div class="form-group mb-3">
                                      <label for="">Section Title</label>
                                      <input type="text" class="form-control" name="section_title" value="{{$section->section_title}}" required>
                                      <input type="text" hidden name="id" value="{{$section->id}}">
                                    </div>
                                    <div class="form-group mb-3">
                                      <label for="">Section Description</label>
                                      <textarea name="section_desc" class="form-control">{{$section->section_desc}}</textarea>
                                      <small>(If you want to hide this. Leave Empty this field.)</small>
                                    </div>
                                    <div class="form-group mb-3">
                                      <label class="form-label">Status</label>
                                      <select name="status" class="form-control" required>
                                        <option value="1" @if($section->status == '1') selected @endif>Active</option>
                                        <option value="0" @if($section->status == '0') selected @endif>Inactive</option>
                                      </select>
                                    </div>
                                    <button class="btn btn-primary updateHomeSection" type="button">Update</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                            @endforeach
                          </div>
                            {{-- <div class="form-group mb-3">
                              <label class="form-label">Name</label>
                              <input type="text" class="form-control" name="name" value="{{$gateway->name}}" required>
                              <input type="text" hidden class="id" value="{{$gateway->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Image</label>
                              <input type="file" name="image" class="form-control" onChange="readURL(this);" />
                              @if($gateway->image != '')
                              <img id="image" src="{{asset('public/payment/'.$gateway->image)}}" width="100px">
                              @else
                              <img id="image" src="{{asset('public/payment/default.png')}}" width="100px">
                              @endif
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($gateway->status == '1') selected @endif>Active</option>
                                <option value="0" @if($gateway->status == '0') selected @endif>Inactive</option>
                              </select>
                            </div> --}}
                            
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
<script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
<script type="text/javascript">
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