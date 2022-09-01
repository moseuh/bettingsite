@extends('layout')

@section('css')

@stop
@section('content')

@include('partials.breadcrumb')


<!--    blog lists start   -->
<div class="blog-lists">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach($blogs as $data)
                        <div class="single-blog">
                            <div class="blog-img-wrapper">
                                <img src="{{asset('public/images/blog/'.$data->image)}}" alt="{{$data->title}}">
                                <div class="blog-img-overlay"></div>
                            </div>
                            <div class="blog-txt">
                                <p class="date">{{date('F d, Y',strtotime($data->created_at))}} </p>
                                <h3 class="blog-title"><a href="{{route('info',[str_slug($data->title), $data->id])}}">{{$data->title}}</a></h3>
                                <p class="blog-summary">{{str_limit(strip_tags($data->details),200)}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row ">
                    <div class="col-lg-12">

                        <div class="pagination-nav ">

                            {{$blogs->links()}}
                        </div>
                    </div>
                </div>
            </div>
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
        </div>
    </div>
</div>
<!--    blog lists end   -->


@stop

@section('js')

@stop
