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
                        <nav class="pagination-nav ">
                            {{$blogs->links()}}
                        </nav>
                    </div>
                </div>
            </div>

            @include('partials.popular-blog')
        </div>
    </div>
</div>
<!--    blog lists end   -->


@stop

@section('js')

@stop
