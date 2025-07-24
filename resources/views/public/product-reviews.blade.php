@extends('public.layout.layout')
@section('title','Product Reviews : ')
@section('content')
@component('public.layout.page-header',['breadcrumb'=>['Home'=>'/']])
@slot('title') Product Reviews @endslot
@slot('active') Product Reviews @endslot
@endcomponent
<section id="page-content" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-single d-flex">
                    @if($product->thumbnail != '')
                    <img src="{{asset('public/products/'.$product->thumbnail)}}" alt="">
                    @else
                    <img src="{{asset('public/products/default.png')}}" alt="">
                    @endif
                    <div class="product-content flex-grow-1">
                        <h3><a href="{{url('product/'.$product->slug)}}">{{$product->title}}</a></h3>
                        <span>Price : {{cur_format()}}{{$product->price}}</span>
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
                    </div>
                </div>
                <form id="submit-review" class="position-relative mb-5">
                    <span>Choose Star Rating</span>
                    <div class="form-group rating-stars">
                        <div class="rate mb-2">
                            <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                            <label for="star5" title="5 Stars">5 stars</label>
                            <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                            <label for="star4" title="4 Stars">4 stars</label>
                            <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                            <label for="star3" title="3 Stars">3 stars</label>
                            <input type="radio" id="star2" class="rate" name="rating" value="2">
                            <label for="star2" title="2 Stars">2 stars</label>
                            <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                            <label for="star1" title="1 Stars">1 star</label>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Add Review</label>
                        <textarea name="review" class="form-control"></textarea>
                    </div>
                    <input type="submit" class="btn" value="Submit">
                </form>
                @if($reviews->isNotEmpty())
                <div class="page-widget border p-4 mb-4">
                    <h4>Reviews</h4>
                    @foreach($reviews as $review)
                    <div class="review-box border">
                        <div class="user-info d-flex mb-2">
                            <div class="user-img">
                                <img src="{{asset('public/users/default.png')}}" alt="" width="50px">
                            </div>
                            <h6 class="align-self-center m-0">{{$review->name}}</h6>
                        </div>
                        <ul class="rating d-flex list-unstyled mb-2">
                            @for($i=1;$i<=5;$i++)
                            <li><i class="bi @if($review->rating >= $i) bi-star-fill @else bi-star @endif"></i></li>
                            @endfor
                        </ul>
                        <p>{{htmlspecialchars_decode($review->feedback)}}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <span>No Reviews Found</span>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection