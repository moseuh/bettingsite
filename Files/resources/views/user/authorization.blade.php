@extends('layout')

@section('css')

@stop
@section('content')

    @include('partials.breadcrumb')


    @if(Auth::user()->status == 0)
    <!--    blog lists start   -->
    <div class="faq-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="left-side">
                        <div class="part-text-top">
                            <h2 class="subtitle  text-center text-danger">@lang('Your Account has been Suspended')</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    blog lists end   -->

    @elseif(Auth::user()->email_verify == 0)
    <div class="contact-section">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section smoke-bg py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <div class="part-text-top">
                            <h2 class="subtitle">@lang('E-mail Verification')</h2>
                        </div>





                        <strong class="mb-4">@lang('Your E-mail'): <span class="error"> {{Auth::user()->email}}</span>
                        </strong>
                        <form action="{{ route('user.email-verify')}}" method="post">
                            @csrf
                            <div class="row">



                                <div class="col-md-12">
                                    <div class="form-element">
                                        <input type="text" name="email_code" placeholder="@lang('Enter Code')" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-block"><span>@lang('Submit')</span></button>
                                    </div>
                                    <a  href="{{ route('user.send-emailVcode') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('rd-form').submit();">
                                        {{ __('Resend Code') }}
                                    </a>

                                </div>
                            </div>
                        </form>


                        <form class="rd-form" id="rd-form" method="POST" action="{{route('user.send-emailVcode')}}">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <!--  contact form and map end  -->
        </div>
    </div>
    @elseif(Auth::user()->phone_verify == 0)

        <div class="contact-section">
            <div class="container">
                <!--  contact form and map start  -->
                <div class="contact-form-section smoke-bg py-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <div class="part-text-top">
                                <h2 class="subtitle">@lang('SMS Verification')</h2>
                            </div>





                            <strong class="mb-4">@lang('Your Contact Number'): <span class="error"> {{Auth::user()->phone}}</span>
                            </strong>
                            <form action="{{ route('user.sms-verify')}}" method="post">
                                @csrf
                                <div class="row">



                                    <div class="col-md-12">
                                        <div class="form-element">
                                            <input type="text" name="sms_code" placeholder="@lang('Enter Code')" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-element">
                                            <button type="submit" class="btn btn-block"><span>@lang('Submit')</span></button>
                                        </div>
                                        <a  href="{{ route('user.send-vcode') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('rd-sms-form').submit();">
                                            {{ __('Resend Code') }}
                                        </a>

                                    </div>
                                </div>
                            </form>


                            <form class="rd-form" id="rd-sms-form" method="POST" action="{{route('user.send-vcode')}}">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <!--  contact form and map end  -->
            </div>
        </div>
    @else
        <script>
            window.location.href = "{{route('home')}}";
        </script>

    @endif


@stop

@section('js')

@stop
