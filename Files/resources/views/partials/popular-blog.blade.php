<!--    blog sidebar section start   -->
<div class="col-xl-4 offset-xl-1 col-lg-4">
    <div class="sidebar">

        <div class="blog-sidebar-widgets post-widget">
            <div class="popular-posts-lists">
                <h4>@lang("Popular Posts")</h4>
                @foreach($popular as $data)
                    <div class="single-popular-post">
                        <div class="popular-post-img-wrapper">
                            <img src="{{asset('public/images/blog/'.$data->image)}}" alt="{{$data->title}}">
                        </div>
                        <div class="popular-post-txt">
                            <h5 class="popular-post-title"><a href="{{route('info',[str_slug($data->title), $data->id])}}">{{str_limit($data->title,30)}}</a></h5>
                            <small class="time">{{diffForHumans($data->created_at)}}</small>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>
<!--    blog sidebar section end   -->