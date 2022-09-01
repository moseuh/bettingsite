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

                        <form method="POST" action="{{ route('user.password.request') }}">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="email" class="font-weight-bold text-white">@lang('Email Address')</label>
                                        <input type="email" name="email" value="{{$email}}" placeholder="@lang('Email Address')" readonly>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="password" class="font-weight-bold text-white">@lang('New Password')</label>
                                        <input type="password" name="password" placeholder="@lang('New Password')" >
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="password_confirmation" class="font-weight-bold text-white">@lang('Re Password')</label>
                                        <input type="password" name="password_confirmation" placeholder="@lang('Re Password')" >
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-block"><span>@lang('Submit')</span></button>
                                    </div>
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



