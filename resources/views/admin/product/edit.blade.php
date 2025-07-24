@extends('admin.partials.layout')
@section('title','Edit Product : ')
@section('pageStyleLinks')
<link rel="stylesheet" href="{{asset('public/assets/css/image-uploader.css')}}">
<!-- Tokenfield for Bootstrap-->
<link rel="stylesheet" href="{{asset('public/assets/css/tokenfield.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/css/trumbowyg.min.css')}}">
@stop
@section('content')
<main id="main" class="main">
    @component('admin.partials.page-head',['breadcrumb'=>['Dashboard'=>'/admin/dashboard','Products'=>'admin/products']])
        @slot('title') Edit Product @endslot
        @slot('add_btn') @endslot
        @slot('active') Edit @endslot
    @endcomponent
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body py-3">
                        <form class="g-3 needs-validation" id="updateProduct">
                          @csrf
                          {{ method_field('PUT') }}
                            <div class="form-group mb-3">
                              <label class="form-label">Title</label>
                              <input type="text" class="form-control" name="product_title" value="{{$product->title}}" required>
                              <input type="text" hidden class="id" value="{{$product->id}}">
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Slug</label>
                              <input type="text" class="form-control" name="product_slug" value="{{$product->slug}}" required>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Category</label>
                              <select name="category" id="category" class="form-control">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($category as $cat)
                                @php $selected = ($cat->id == $product->category) ? 'selected' : '';  @endphp
                                <option value="{{$cat->id}}"  {{$selected}}  >{{$cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Sub Category</label>
                              <select name="sub_category" id="sub-category" class="form-control">
                                @foreach($sub_category as $sub_cat)
                                @php $selected = ($sub_cat->id == $product->sub_category) ? 'selected' : '';  @endphp
                                <option value="{{$sub_cat->id}}"  {{$selected}}  >{{$sub_cat->name}}</option>
                                @endforeach
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Tags</label>
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
                              <input id="tokenfield" type="text" class="form-control" name="tags" value="{{$tag_names}}" placeholder="Type and hit enter to add a tag"/>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Price</label>
                              <input type="number" class="form-control" min="0" name="price" value="{{$product->price}}" />
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Thumbnail</label>
                              <input type="file" name="thumb" class="form-control" onChange="readURL(this);" />
                              @if($product->thumbnail != '')
                              <img id="image" src="{{asset('public/products/'.$product->thumbnail)}}" width="100px">
                              @else
                              <img id="image" src="{{asset('public/products/default.jpg')}}" width="100px">
                              @endif
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Images</label>
                              <div class="product-images"></div>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Description</label>
                              <textarea name="desc" class="tinymce-editor">{!!$product->desc!!}</textarea>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Preview Link</label>
                              <input type="text" class="form-control" name="preview_link" value="{{$product->preview_link}}" />
                            </div>
                            @if($product->user == '1')
                            <div class="form-group mb-3">
                              <label class="form-label">Downloadable File (zip)</label>
                              <input type="file" name="download_file" class="form-control">
                              <input type="file" name="old_file" hidden value="{{$product->download_file}}"/>
                            </div>
                            @else
                            <div class="form-group mb-3">
                              <label class="form-label">Downloadable File (zip)</label>
                              <a href="{{url('product/'.$product->slug.'/download')}}" class="btn mb-2 btn-primary"><i class="bi bi-download"></i> Download</a>
                              <input type="file" name="old_file" hidden value="{{$product->download_file}}"/>
                            </div>
                            @endif
                            <div class="form-group mb-3">
                              <label class="form-label">Featured</label>
                              <select name="featured" class="form-control">
                                <option value="1" @if($product->featured == '1') selected  @endif>Yes</option>
                                <option value="0" @if($product->featured == '0') selected  @endif>No</option>
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Approved</label>
                              <select name="approve" class="form-control">
                                <option value="1" @if($product->approved == '1') selected  @endif>Yes</option>
                                <option value="0" @if($product->approved == '0') selected  @endif>No</option>
                              </select>
                            </div>
                            <div class="form-group mb-3">
                              <label class="form-label">Status</label>
                              <select name="status" class="form-control">
                                <option value="1" @if($product->status == '1') selected @endif>Active</option>
                                <option value="0" @if($product->status == '0') selected @endif>Inactive</option>
                                <option value="2" @if($product->status == '2') selected @endif>Hidden</option>
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
@php
$images = array_filter(explode(',',$product->images));
$images_array = [];
for($i=0;$i<count($images);$i++){
    $g = (object) array('id'=>$i+1,'src'=>asset('public/products/'.$images[$i]));
    array_push($images_array,$g);
}

@endphp
@stop
@section('pageJsScripts')
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('public/assets/js/image-uploader.js')}}"></script>
<!-- Tokenfield Js -->
<script src="{{asset('public/assets/js/tokenfield.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
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
    $(function () {

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
    });
</script>
@stop