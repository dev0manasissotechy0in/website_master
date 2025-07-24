<div class="pagetitle d-flex flex-row justify-content-between">
    <div>
        <h1>{{$title}}</h1>
        <nav>
            <ol class="breadcrumb">
                @foreach($breadcrumb as $key => $value)
                <li class="breadcrumb-item"><a href="{{url($value)}}">{{$key}}</a></li>
                @endforeach
                <li class="breadcrumb-item active">{{$active}}</li>
            </ol>
        </nav>
    </div>
    {{$add_btn}}
</div><!-- End Page Title -->