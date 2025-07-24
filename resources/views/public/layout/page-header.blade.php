<section id="page-header" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>{{$title}}</h2>
                <ol class="breadcrumb justify-content-center">
                    @foreach($breadcrumb as $key => $value)
                    <li class="breadcrumb-item"><a href="{{url($value)}}">{{$key}}</a></li>
                    @endforeach
                    <li class="breadcrumb-item active">{{$active}}</li>
                </ol>
            </div>
        </div>
    </div>
</section>