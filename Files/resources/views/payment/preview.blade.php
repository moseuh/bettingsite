@extends('user')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">Payment Preview</div>


                <div class="card-body">
                        <ul class="list-group">

                        <li class="list-group-item">
                            <img src="{{get_image(config('constants.deposit.gateway.path') .'/'. $depo->gateway->image) }}" class="payment-preview-img" />
                        </li>


                        <p class="list-group-item">
                            @lang('Amount'): <strong>{{formatter_money($depo->amount)}} </strong> {{$general->cur_text}}
                        </p>


                        <p class="list-group-item">
                            @lang('Conversion Rate'): <strong>1 {{$depo->baseCurrency()}} =  {{formatter_money($depo->rate)}} {{$general->cur_text}}  </strong>
                        </p>



                        <p class="list-group-item">
                            @lang('In') {{$depo->baseCurrency()}}: <strong>{{formatter_money($depo->amount/$depo->rate)}}</strong>
                        </p>

                        <p class="list-group-item">
                            @lang('Charge'): <strong>{{formatter_money($depo->charge)}}</strong> {{$depo->baseCurrency()}}
                        </p>

                        <p class="list-group-item">
                            @lang('Payable'): <strong> {{$depo->final_amo}}</strong> {{$depo->baseCurrency()}}
                        </p>
                        @if($depo->gateway->crypto==1)
                            <p class="list-group-item">
                                @lang('Conversion with') <b> {{ $depo->method_currency }}</b> @lang('and final value will Show on next step')
                            </p>
                        @endif
                        </ul>


                    <a href="{{route('user.deposit.confirm')}}" class="btn btn-success btn-block">@lang('Pay Now')</a>



                </div>
            </div>



        </div>
    </div>
@endsection

