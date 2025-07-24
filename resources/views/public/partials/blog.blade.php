<div class="col-md-4 mb-4">
    <div class="blog-grid h-100">
        <a href="{{url('blog/'.$blog->slug)}}" class="blog-img d-block">
            @if($blog->image != '')
            <img src="{{asset('public/blogs/'.$blog->image)}}" class="w-100" alt="">
            @else
            <img src="{{asset('public/blogs/default.png')}}" class="w-100" alt="">
            @endif
        </a>
        <div class="blog-content mt-auto">
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-calendar"></i> {{date('M-d-Y',strtotime($blog->created_at))}}</span>
                <span><a href="{{url('blogs/c/'.$blog->cat_name->slug)}}">{{$blog->cat_name->name}}</a></span>
            </div>
            <h3 class="title"><a href="{{url('blog/'.$blog->slug)}}">{{substr($blog->title,0,60).'...'}}</a></h3>
        </div>
    </div>
</div>