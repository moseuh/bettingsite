@extends('user')

@section('content')
    @include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="faq-section">
        <div class="container">
            <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <form action="{{route('money.transfer')}}" method="post" class=" smoke-bg p-5">
                            @csrf
                            <div class="row">

                                <div class="col-md-12">
                                    <h4 class="text-center text-white">@lang('Fill up below the instruction')</h4>
                                    <h6 class="text-center text-info">@lang('Limit') : {{$basic->min_transfer}} -{{$basic->max_transfer}} {{$basic->currency}}</h6>
                                    <h6 class="text-center text-info">@lang('Charge') : {{$basic->transfer_charge}} %</h6>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="email" class="font-weight-bold text-white">@lang('Email Address')</label>
                                        <input type="email" name="email" value="{{old('email')}}" placeholder="@lang('Email Address')" >

                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ __($errors->first('email')) }}</span>
                                        @endif
                                    </div>
                                </div>

                                 <div class="col-md-12">
                                    <div class="form-element">
                                        <label for="amount" class="font-weight-bold text-white">@lang('Amount')</label>
                                        <input type="text" name="amount" placeholder="0.00" value="{{old('amount')}}"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                        @if ($errors->has('amount'))
                                            <span class="text-danger">{{ $errors->first('amount') }}</span>
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
                                    <div class="form-element mt-3">
                                        <button type="submit" class="btn btn-block"><span>@lang('Submit')</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

        </div>
    </div>
    <!--   contact section end    -->
@stop



