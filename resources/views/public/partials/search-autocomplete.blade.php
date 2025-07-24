<ul>
    <li><a href="{{url('search?s='.$txt)}}"><b>{{$txt}}</b></a></li>
    @foreach($category as $cat)
    @if($cat->products_count > 0)
    <li><a href="{{url('product/c/'.$cat->slug.'?s='.$txt)}}"><b>{{$txt}}</b> in {{$cat->name}}</a></li>
    @endif
    @endforeach
</ul>