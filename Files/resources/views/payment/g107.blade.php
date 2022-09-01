@extends('user')

@section('css')
@stop
@section('content')

   

    @include('partials.breadcrumb')

    <div class="faq-section shadow-bg">
        <div class="container">


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-deposit">
                        <div class="card-header custom-header text-center">
                            <h4 class="card-title">@lang('PayStack Payment')</h4>
                        </div>
                        <div class="card-body text-center">

                            <div class="row justify-content-center">
                                <div class="col-md-4">

                                    <div class="card ">
                                        <div class="card-body card-body-deposit">
                                            <img src="{{asset('public/images/gateways/'. $deposit->gateway_currency()->image)}}" class="card-img-top w-80p" alt="payment" >
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group font-weight-bold">






                                <li class="list-group-item">@lang('Please Pay') {{formatter_money($deposit->final_amo)}} {{$deposit->method_currency}}</li>

                                <li class="list-group-item">@lang('To Get') {{formatter_money($deposit->amount)}}  {{$deposit->method_currency}}</li>


                                <li class="list-group-item">

                                <button type="button" class="mt-4 btn-success btn-round custom-success text-center btn-lg" id="btn-confirm">@lang('Pay Now')</button>

                                

                                <form action="{{ route('g107') }}" method="POST" class="text-center">
                                    @csrf

                                   <script
                                        src="//js.paystack.co/v1/inline.js"
                                        data-key="{{ $data->key }}"
                                        data-email="{{ $data->email }}"
                                        data-amount="{{$data->amount}}"
                                        data-currency="{{$data->currency}}"
                                        data-ref="{{ $data->ref }}"
                                        data-custom-button="btn-confirm"
                                    >
                                    </script>
                                </form>

                                        </li>
                                    </ul>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>




@endsection

@section('js')

@stop


