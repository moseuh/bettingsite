@extends('user')

@section('content')
    @include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="contact-section">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section smoke-bg py-5 px-3">
                <div class="row justify-content-center">
                    <div class="col-lg-8">


                        <form method="POST" action="">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="current_password" class="font-weight-bold text-white">@lang('Current Password')</label>
                                        <input type="password" name="current_password" placeholder="@lang('Current Password')" >

                                        @if ($errors->has('current_password'))
                                            <span class="text-danger">{{ __($errors->first('current_password')) }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="password" class="font-weight-bold  text-white">@lang('New Password')</label>
                                        <input type="password" name="password" placeholder="@lang('New Password')" >
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="password_confirmation" class="font-weight-bold  text-white">@lang('Re Password')</label>
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



