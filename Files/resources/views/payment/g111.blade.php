@extends('user')

@section('css')
    <script src="https://js.stripe.com/v3/"></script>
@stop
@section('content')

    <style>
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>

    @include('partials.breadcrumb')

    <div class="faq-section shadow-bg">
        <div class="container">


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-deposit">
                        <div class="card-header custom-header text-center">
                            <h4 class="card-title">@lang('Stripe Payment')</h4>
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
                                        <li class="list-group-item">@lang('Amount') : {{formatter_money($deposit->amount,2)}} {{$basic->currency}}</li>
                                        <li class="list-group-item">@lang('Charge') : {{formatter_money($deposit->charge,2)}} {{$basic->currency}}</li>
                                        <li class="list-group-item">@lang('Rate') : {{formatter_money($deposit->rate,2)}} {{$deposit->method_currency}}</li>
                                        <li class="list-group-item">@lang('Payable Amount') : {{formatter_money($deposit->final_amo,2)}} {{$deposit->method_currency}}</li>

                                        <li class="list-group-item">
                                            <form action="{{$data->url}}" method="{{$data->method}}">
                                                <script
                                                        src="{{$data->src}}"
                                                        class="stripe-button"
                                                        @foreach($data->val as $key=> $value)
                                                        data-{{$key}}="{{$value}}"
                                                        @endforeach
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


