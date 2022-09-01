<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$basic->sitename}} @isset($page_title) | {{@$page_title}} @endif</title>
    <meta name="keywords" content="{{$basic->meta_keywords}}" />
    <meta name="description" content="{{$basic->meta_description}}"/>
    
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Source+Sans+Pro:400,600,700&amp;display=swap" rel="stylesheet">


    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('public/images/logo/favicon.png')}}" type="image/x-icon">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{asset('public/templates/css/file.min.css')}}">
    @yield('load-css')

    @yield('css')
    <!-- responsive css -->
    <link rel="stylesheet" href="{{asset('public/templates/css/responsive.css')}}">
    <!-- jquery js -->
    <script src="{{asset('public/templates/js/jquery-1.10.2.min.js')}}"></script>
</head>

<body>


<!--  Header Section Start  -->
<div class="header-section home-3">
    <div class="info-area">
        <div class="container">
            <div class="row">
                @include('partials.social')

                <div class="col-md-6">
                    <ul class="socials float-right">
                        @guest
                        <li><a href="javascript:void(0)"><i class="fa fa-envelope"></i> {{$basic->email}}</a></li>
                        <li><a href="javascript:void(0)"><i class="fa fa-phone"></i> {{$basic->phone}}</a></li>
                        @endguest
                        @auth
                                <li><a href="javascript:void(0)"><i class="fa fa-wallet"></i> @lang('Balance') : {{number_format(Auth::user()->balance,$basic->decimal)}} {{$basic->currency}}</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--  Navbar Area Start  -->
    <div class="nav-area">
        <div class="main-menu">
            <div class="container">
                <div class="row align-items-center position-relative">
                    <div class="col-lg-3 col-6">
                        <a class="logo-wrapper" href="{{route('site')}}"><img src="{{asset('public/images/logo/logo.png')}}" alt=""></a>
                    </div>
                    <div class="col-lg-9 col-6 position-static">
                        <nav>
                            <ul class="menus" id="mainMenu">
                                <li @if(Request::routeIs('site')) class="active" @endif><a href="{{route('site')}}" class="parent-link">@lang('Home')</a></li>

                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="parent-link">@lang('Tournament')</a>
                                    <ul class="dropdown-lists">
                                        @foreach($tournaments as $event)
                                        <li><a href="{{route('tournament',[str_slug($event->name),$event->id])}}">{{$event->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>


                                <li @if(Request::routeIs('about')) class="active" @endif><a href="{{route('about')}}" class="parent-link">@lang('About Us')</a></li>
                                <li @if(Request::routeIs('blog')) class="active" @endif><a href="{{route('blog')}}" class="parent-link">@lang('Blog')</a></li>

                                <li @if(Request::routeIs('faq')) class="active" @endif><a href="{{route('faq')}}" class="parent-link">@lang('FAQS')</a></li>
                                <li @if(Request::routeIs('contact')) class="active" @endif><a href="{{route('contact')}}" class="parent-link">@lang('Contact Us')</a></li>


                                @guest
                                    <li class="dropdown">
                                        <a href="#" class="parent-link">@lang('Account')</a>
                                        <ul class="dropdown-lists">
                                            <li><a href="{{route('login')}}">@lang('Sign In')</a></li>
                                            <li><a href="{{route('register')}}">@lang('Sign Up')</a></li>
                                        </ul>
                                    </li>
                                @endguest
                                @auth
                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="parent-link">{{Auth::user()->username}}</a>
                                    <ul class="dropdown-lists">
                                        <li><a href="{{route('home')}}">@lang('Dashboard')</a></li>
                                        <li><a href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">@lang('Logout')</a></li>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </ul>
                                </li>
                                @endauth



                            </ul>

                            <div id="mobileMenu"></div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Navbar Area End  -->
</div>
<!--  Header Section End  -->


@yield('content')
@include('partials.footer')

<!-- back to top area start -->
<div class="back-to-top">
    <i class="fas fa-chevron-up"></i>
</div>
<!-- back to top area end -->





<!-- popper js -->
<script src="{{asset('public/templates/js/file.min.js')}}"></script>

@yield('load-js')

@include('partials.notify')
@yield('js')



</body>

</html>
