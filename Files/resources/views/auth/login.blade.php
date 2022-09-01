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

                        <form action="{{route('login')}}" method="post">
                            @csrf
                            <div class="row">

                                @if (session()->has('status'))
                                <div class="col-md-12">
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <span class="error">{{ session()->get('status') }}</span>
                                        </div>
                                </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="username" class="font-weight-bold text-white">@lang('Username')</label>
                                        <input type="text" name="username" placeholder="@lang('Username')" >
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="password" class="font-weight-bold text-white">@lang('Password')</label>
                                        <input type="password" name="password" placeholder="@lang('Password')" >
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-block"><span>@lang('Sign In')</span></button>
                                    </div>
                                    <a href="{{route('password.request')}}">@lang('Forget Password')</a>
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



