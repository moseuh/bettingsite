@extends('layout')

@section('css')

@stop
@section('content')
    @php

    $page_title = '404';
    @endphp

    @include('partials.breadcrumb')

<div class="error-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-txt">
                    <div class="oops">
                        <img src="{{asset('public/templates/img/oops.png')}}" alt="">
                    </div>
                    <h2>@lang('Page Not Found')</h2>
                    <a href="{{url('/')}}" class="go-home-btn">@lang('Back Home')</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop