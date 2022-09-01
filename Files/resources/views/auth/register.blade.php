@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('public/templates/css/intlTelInput.css')}}">
@stop

@section('content')
    @include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="contact-section">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section smoke-bg py-5 px-3">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <form action="{{route('register')}}" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-element">

                                        <label for="first_name" class="font-weight-bold text-white">@lang('First Name')</label>

                                        <input type="text" name="first_name" placeholder="@lang('First Name')" value="{{old('first_name')}}">
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label for="last_name" class="font-weight-bold text-white">@lang('Last Name')</label>
                                        <input type="text" name="last_name" placeholder="@lang('Last Name')" value="{{old('last_name')}}">
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label for="username"  class="font-weight-bold text-white">@lang('Username')</label>
                                        <input type="text" name="username" placeholder="@lang('Username')" value="{{old('username')}}">
                                        @if ($errors->has('username'))
                                            <span class="text-danger">{{ $errors->first('username') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label for="phone"  class="font-weight-bold text-white">@lang('Contact Number')</label>
                                        <input type="hidden" id="track" name="country_code">

                                        <input type="tel" name="phone" id="phone" placeholder="@lang('Contact Number')">

                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                    <div class="form-wrap d-none" >
                                        <label class="form-label rd-input-label"></label>
                                        <input type="text" id="country" readonly name="country" value="{{old('country')}}" class="form-input form-control-last-child {{ $errors->has('country') ? ' form-control-has-validation' : '' }}" autocomplete="off" placeholder="Country...">
                                        @if ($errors->has('country'))
                                            <span class="form-validation">{{ __($errors->first('country')) }}</span>
                                        @endif
                                    </div>


                                    <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="email"  class="font-weight-bold text-white">@lang('E-mail Address')</label>
                                        <input type="text" name="email" placeholder="@lang('E-mail Address')" value="{{old('email')}}">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label for="password"  class="font-weight-bold text-white">@lang('Password')</label>
                                        <input type="password" name="password" placeholder="@lang('Password')">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label for="password"  class="font-weight-bold text-white">@lang('Repeat Password')</label>
                                        <input type="password" name="password_confirmation"
                                               placeholder="@lang('Repeat Password')">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-element mt-3">
                                        <button type="submit" class="btn btn-block"><span>@lang('Sign Up')</span>
                                        </button>
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

@section('js')
    <script src="{{asset('public/templates/js/intlTelInput.js')}}"></script>
    <script>
        $("#phone").on("countrychange", function(e, countryData) {
            // do something with countryData
            console.log(countryData);
            var data =  $(this).val('+' + countryData.dialCode)
            $('#track').val(data);
            var country = countryData.name;
            var country = country.split('(')[0];
            $('#country').val(country);
        });
        $("#phone").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            // hiddenInput: "full_number",
            initialCountry: "auto",
            utilsScript: "{{asset('public/templates/js/utils.js')}}"
        });
    </script>
@endsection

