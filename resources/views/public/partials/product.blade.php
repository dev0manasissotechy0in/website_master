<div class="product-grid d-flex flex-column">
    @if(Request::url() == url('my-wishlist'))
    <button type="button" class="overlay-btn remove-wishlist" data-id="{{$product->id}}"><i class="bi bi-x"></i></button>
    @endif
    <div class="product-img">
        @if($product->featured == '1')
        <span class="featured-badge"><i class="bi bi-star-fill"></i></span>
        @endif
        <a href="{{url('product/'.$product->slug)}}" class="image d-block">
            @if($product->thumbnail != '')
            <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="" class="w-100">
            @else
            <img src="{{asset('public/products/default.png')}}" alt="" class="w-100">
            @endif
        </a>
        <ul class="product-links d-flex list-unstyled">
            @if(!session()->has('user_type') || session()->get('user_type') != 'seller')
            @if(session()->has('user_sess'))
            @php $wishlist = user_cart(); @endphp
            <li class="@if(in_array($product->id,$wishlist)) active @endif"><a href="javascript:void(0);" data-id="{{$product->id}}" class="add-wishlist" ><i class="bi bi-heart-fill"></i></a></li>
            @else
            <li><a href="{{url('login')}}" ><i class="bi bi-heart-fill"></i></a></li>
            @endif
            @php $cart = user_cart(); @endphp
            <li class="@if(in_array($product->id,$cart)) active @endif"><a href="javascript:void(0);" data-id="{{$product->id}}" class="add-cart"><i class="bi bi-basket-fill"></i></a></li>
            @endif
            <li><a href="{{url('product/'.$product->slug)}}"><i class="bi bi-eye-fill"></i></a></li>
        </ul>
        <span class="product-category"><a href="{{url('product/c/'.$product->cat_name->slug)}}">{{$product->cat_name->name}}</a></span>
    </div>
    <div class="product-content">
        <h3 class="title"><a href="{{url('product/'.$product->slug)}}">{{substr($product->title,0,45).'...'}}</a></h3>
        <div class="d-flex justify-content-between">
            @php $product_rating = product_rating($product->id);  @endphp
            <ul class="rating d-flex list-unstyled">
                @php $rating = 0;  @endphp
                @if($product_rating->rating_col > 0)
                    @php $rating = ceil($product_rating->rating_sum/$product_rating->rating_col);  @endphp  
                @endif
                @for($i=1;$i<=5;$i++)
                    @if($i <= $rating)
                    <li><i class="bi bi-star-fill"></i></li>
                    @else
                    <li><i class="bi bi-star"></i></li>
                    @endif
                @endfor
            </ul>
            <div class="product-price">${{$product->price}}</div>
        </div>
    </div>
    <div class="product-author d-flex justify-content-between mt-auto">
        <div class="author-info d-flex">
            <div class="author-img">
                @if($product->author->image != '')
                <img src="{{asset('public/users/'.$product->author->image)}}" alt="">
                @else
                <img src="{{asset('public/users/default.png')}}" alt="">
                @endif
            </div>
            <span class="align-self-center"><a href="{{url('seller/'.$product->author->user_name)}}">{{$product->author->slug}}</a></span>
        </div>
        <span class="sales-count align-self-center"><i class="bi bi-basket-fill"></i> {{$product->downloads_count}}</span>
    </div>
</div>