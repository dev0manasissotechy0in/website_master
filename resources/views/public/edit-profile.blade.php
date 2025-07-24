@extends('public.layout.layout')
@section('title','Edit Profile : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/','Profile'=>url('user-profile')]])
@slot('title') Edit Profile @endslot
@slot('active') Edit Profile @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form class="border p-4 pt-5 position-relative" id="update-profile" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6 mb-3">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" value="{{$profile->name}}" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Unique Name</label>
                            <input type="text" class="form-control" name="unique_name" value="{{$profile->user_name}}" />
                        </div>
                        @if(session()->get('user_type') == 'seller')
                        <div class="form-group col-6 mb-3">
                            <label for="">Your Unique Slug</label>
                            <input type="text" class="form-control" name="unique_slug" value="{{$profile->slug}}" />
                        </div>
                        @else
                            <input type="text" hidden name="unique_name" value="{{$profile->slug}}" />
                        @endif
                        <div class="form-group col-6 mb-3">
                            <label for="">Phone</label>
                            <input type="number" class="form-control" name="phone" value="{{$profile->phone}}" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Country</label>
                            <input type="text" class="form-control" name="country" value="{{$profile->country}}" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            <label for="">Image</label>
                            <input type="file" class="form-control" name="image" value="{{$profile->name}}" onChange="readURL(this)" />
                        </div>
                        <div class="form-group col-6 mb-3">
                            @if($profile->image != '')
                            <img src="{{asset('public/users/'.$profile->image)}}" width="100px" alt="">
                            @else
                            <img id="image" src="{{asset('public/users/default.png')}}" width="100px"  alt="">
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <input type="submit" class="btn" value="Update" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('pageJsScripts')
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
@endsection