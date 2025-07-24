@extends('public.layout.layout')
@section('title','Edit Product : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
<!-- Tokenfield for Bootstrap-->
<link rel="stylesheet" href="{{asset('public/assets/css/tokenfield.css')}}">
<link rel="stylesheet" href="{{asset('public/frontend/css/trumbowyg.min.css')}}">
@stop
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Edit Product @endslot
@slot('active') Edit product @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="update-product" class="border p-4 pt-5 position-relative" method="POST">
                    @csrf
                    <h3>Edit Product!!!</h3>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group mb-3">
                                <label for="">Product Title : <b>{{$product->title}}</b></label>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Category : <b>{{$product->title}}</b></label>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Sub Category : <b>{{$product->title}}</b></label>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Description</label>
                                <textarea name="desc" id="editor" class="form-control" cols="30" rows="10">{!!$product->desc!!}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Images</label>
                                <div class="product-images"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Preview Link</label>
                                <input type="text" name="preview_link" class="form-control" value="{{$product->preview_link}}" />
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="">Tags</label>
                                @php
                                $tags_id = array_filter(explode(',',$product->tags));
                                $tag_names = '';
                                @endphp
                                @foreach($tags as $tag)
                                    @if(in_array($tag->id,$tags_id))
                                        @php $tag_names == ''? '' : $tag_names.=',';  @endphp
                                        @php $tag_names .= $tag->name; @endphp
                                    @endif
                                @endforeach
                                <input type="text" name="tags" value="{{$tag_names}}" id="tokenfield" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="">Thumbnail</label>
                                <input type="file" class="form-control" name="thumb" onChange="readURL(this);" />
                                @if($product->thumbnail != '')
                                <img src="{{url('public/products/'.$product->thumbnail)}}" id="image" class="w-100 mt-4" alt="">
                                @else
                                <img src="{{url('public/products/default.jpg')}}" id="image" class="w-100 mt-4" alt="">
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <label for="">If you want to change Downloadable File (zip file)</label>
                                    <input type="file" name="download_file" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group mb-3">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" @if($product->status == '1') selected @endif>Active</option>
                                        <option value="0" @if($product->status == '0') selected @endif>Inactive</option>
                                    </select>
                                    <input type="text" hidden class="slug" value="{{$product->slug}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn" value="Update" />
                </form>
            </div>
        </div>
    </div>
</section>
@php
$images = array_filter(explode(',',$product->images));
$images_array = [];
for($i=0;$i<count($images);$i++){
    $g = (object) array('id'=>$i+1,'src'=>asset('public/products/'.$images[$i]));
    array_push($images_array,$g);
}

@endphp
@endsection
@section('pageJsScripts')
<script src="{{asset('public/frontend/js/product.js')}}"></script>
<!-- Tokenfield Js -->
<script src="{{asset('public/assets/js/tokenfield.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('public/frontend/js/trumbowyg.min.js')}}"></script>
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
    $(function(){
        $('#editor').trumbowyg();

        var preloaded = <?php echo json_encode($images_array); ?>;

        $('.product-images').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'images',
            'label': 'Drag and Drop',
            preloadedInputName: 'old',
            maxFiles: 10,
            maxSize: 2 * 1024 * 1024,
        });

        $('#tokenfield').tokenfield({
        autocomplete: {
            delay: 100
        },
        showAutocompleteOnFocus: false
        });
    })
</script>
@endsection