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

                                <li @if(Request::routeIs('home')) class="active" @endif><a href="{{route('home')}}" class="parent-link">@lang('My Prediction')</a></li>


                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="parent-link">@lang('Operations')</a>
                                    <ul class="dropdown-lists">
                                        <li><a href="{{route('payment')}}">Deposit Money</a></li>
                                        @if($basic->withdraw_status == 1)
                                        <li><a href="{{route('user.withdraw-money')}}">@lang('Withdraw Money')</a></li>
                                        @endif
                                        <li><a href="{{route('money-transfer')}}">@lang('Money Transfer')</a></li>

                                    </ul>
                                </li>


                                <li class="dropdown">
                                    <a href="javascript:void(0)" class="parent-link">@lang('My Log')</a>
                                    <ul class="dropdown-lists">

                                        <li><a href="{{route('transaction')}}">@lang('Transaction Log')</a></li>
                                        <li><a href="{{route('depositLog')}}">@lang('Deposit Log')</a></li>
                                        @if($basic->withdraw_status == 1)
                                        <li><a href="{{route('user.withdraw-log')}}">@lang('Withdraw Log')</a></li>
                                        @endif


                                    </ul>
                                </li>


                                @auth
                                    <li class="dropdown">
                                        <a href="javascript:void(0)" class="parent-link">{{Auth::user()->username}}</a>
                                        <ul class="dropdown-lists">
                                            <li><a href="{{route('profile-setting')}}">@lang('Profile Settings')</a></li>
                                            <li><a href="{{route('password-setting')}}">@lang('Password Settings')</a></li>

                                            <li><a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">@lang('Logout')</a></li>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none" >
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





<script src="{{asset('public/templates/js/file.min.js')}}"></script>

@yield('load-js')

@include('partials.notify')
@yield('js')

</body>

</html>
