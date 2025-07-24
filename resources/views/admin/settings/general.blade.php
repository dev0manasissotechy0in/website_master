@extends('admin.partials.layout')
@section('title','General Settings : ')
@section('pageStyleLinks')
<style>
  .custom-checkbox{
    /* display: inline-block; */
    /* vertical-align: bottom; */
    position: relative; 
  }
  .custom-checkbox input[type=checkbox]{
      margin: 0;
      visibility: hidden;
      position: absolute;
      left: 1px;
      top: 1px;
  }
  .custom-checkbox label{
      width: 66px;
      height: 24px;
      border: 2px solid #706d92;
      cursor: pointer;
      border-radius: 10px;
      overflow: hidden;
      display: block;
      position: relative;
      z-index: 1;
      transition: all 0.3s ease;
  }
  .custom-checkbox label:before{
      content: '';
      background: #706d92;
      border-radius: 50px;
      width: 16px;
      height: 16px;
      position: absolute;
      bottom: 2px;
      left: 2px;
      transition: all 0.3s ease;
  }
  .custom-checkbox label:after{
    content: 'hide';
    color: '706d92';
    font-size: 14px;
    font-weight: 700;
    text-transform: capitalize;
    position: absolute;
    left: 22px;
    top: 0;
  }
  .custom-checkbox input[type=checkbox]:checked+label{
      background: #7338ba;
      border: 2px solid #7338ba;
  }
  .custom-checkbox input[type=checkbox]:checked+label:before{
      background: #fff;
      left: 44px;
  }

  .custom-checkbox input[type=checkbox]:checked+label:after{
    content: 'Show';
    color: #fff;
    left: 2px;
  }

  @media only screen and (max-width:767px){
      .custom-checkbox{ margin: 0 0 20px; }
  }
</style>
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard']])
        @slot('title') General Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') General Settings @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateGeneralSettings">
                          @csrf
                          <div class="row">
                            <div class="form-group col-md-12 mb-3">
                              <label class="form-label">Site Name</label>
                              <input type="text" class="form-control" name="website_name" required value="{{$general->site_name}}">
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Site Logo </label>
                              <input type="file" class="form-control mb-3" name="logo" onChange="readURL(this);">
                                @if($general->site_logo != '')
                                <img class="image" src="{{asset('public/settings/'.$general->site_logo)}}" width="200px" alt="">
                                @else
                                <img class="image" src="{{asset('public/settings/default.jpg')}}" width="100px" alt="">
                                @endif
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Favicon </label>
                              <input type="file" class="form-control mb-3" name="favicon" onChange="readURL(this);">
                                @if($general->favicon != '')
                                <img class="image" src="{{asset('public/settings/'.$general->favicon)}}" width="25px" alt="">
                                @else
                                <img class="image" src="" width="25px" alt="">
                                @endif
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Site Email</label>
                              <input type="text" class="form-control" name="website_email" value="{{$general->site_email}}" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Site Contact</label>
                              <input type="text" class="form-control" name="website_contact" value="{{$general->site_contact}}" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Address</label>
                              <textarea name="address" class="form-control">{{$general->address}}</textarea>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="form-control">{{$general->site_desc}}</textarea>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" value="{{$general->country}}" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="form-label">Currency Format</label>
                                <input type="text" class="form-control" name="currency_format" value="{{$general->cur_format}}" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label class="form-label">Copyright Text</label>
                              <input type="text" class="form-control" name="copyright_text" value="{{$general->copyright_txt}}" />
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label for="">Show Contact Number in website footer</label>
                              <div class="custom-checkbox">
                                <input type="checkbox" id="show-contact" name="show_contact" @if($general->show_contact == '1') checked @endif />
                                <label for="show-contact"></label>
                              </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                              <label for="">Show Email Address in website footer</label>
                              <div class="custom-checkbox">
                                <input type="checkbox" id="show-email" name="show_email" @if($general->show_email == '1') checked @endif />
                                <label for="show-email"></label>
                              </div>
                            </div>
                          </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Seo Title</label>
                                <input type="text" class="form-control" name="seo_title" value="{{$general->site_seo_title}}" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Seo Description</label>
                                <textarea name="seo_desc" class="form-control">{{$general->site_seo_desc}}</textarea>
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
                // $('#image').attr('src', e.target.result);
                $(input).siblings('.image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop