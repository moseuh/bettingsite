@extends('layout')

@section('content')
    @include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="contact-section">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section smoke-bg py-5 px-3">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <form method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="email" class="font-weight-bold text-white">@lang('Email Address')</label>
                                        <input type="email" name="email" placeholder="@lang('Email Address')" >
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-block"><span>@lang('Submit')</span></button>
                                    </div>
                                    <a href="{{route('login')}}">@lang('Sign In')</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--  contact form and map end  -->
        </div>
    </div>
    <!--   contact section end    -->
@stop



