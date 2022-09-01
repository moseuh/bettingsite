@include('cookieConsent::index')

<!--    Footer Area Start    -->
<footer>
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <a class="logo-wrapper" href="{{url('/')}}"><img src="{{asset('public/images/logo/footer-logo.png')}}" alt=""></a>
                    <p class="txt">{{__($basic->footer_about)}}</p>
                </div>
                <div class="col-xl-2 offset-xl-1 col-lg-2 col-md-2">
                    <h4>Useful Links</h4>
                    <ul class="links">
                        <li><a href="{{route('home')}}">@lang('Home')</a></li>
                        <li><a href="{{route('about')}}">@lang('About Us')</a></li>
                        <li><a href="{{route('blog')}}">@lang('Blog')</a></li>
                        <li><a href="{{route('faq')}}">@lang('FAQS')</a></li>
                    </ul>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-3">
                    <ul class="links mt-5">
                        <li><a href="{{route('register')}}">@lang('Sign Up')</a></li>
                        <li><a href="{{route('contact')}}">@lang('Contact Us')</a></li>
                        <li><a href="{{route('terms')}}">@lang('Terms & Conditions')</a></li>
                        <li><a href="{{route('policy')}}">@lang('Policy')</a></li>
                    </ul>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <h4>@lang('Contact Us')</h4>
                    <div class="contact-infos">
                        <div class="single-info">
                            <div class="icon-wrapper"><i class="flaticon-placeholder"></i></div>
                            <p>{{__($basic->address)}}</p>
                        </div>
                        <div class="single-info">
                            <div class="icon-wrapper"><i class="flaticon-phone-auricular-hand-drawn-ringing-tool-outline"></i></div>
                            <p>{{__($basic->phone)}}</p>
                        </div>
                        <div class="single-info">
                            <div class="icon-wrapper"><i class="flaticon-message"></i></div>
                            <p>{{__($basic->email)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© Copyrights {{date('Y')}} {{$basic->sitename}}. All rights reserved. </p>
        </div>
    </div>
</footer>
<!--    Footer Area End    -->

