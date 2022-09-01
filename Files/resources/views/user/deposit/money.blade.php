@extends('user')

@section('css')
    <link rel="stylesheet" href="{{asset('public/templates/css/deposit.css')}}">
@stop
@section('content')
    <style>

    </style>

    @include('partials.breadcrumb')

    <div class="faq-section ">
        <div class="container">


            <div class="row">


                <div class="col-md-12 mb-4">

                    <div class="panel-body bg-white" >
                        <h4 class="title">@lang('Make Deposit Request Via Payment Method')</h4>

                        <div class="row">

                            @foreach($gatewayCurrency as $data)
                                <div class="col-md-6 ">
                                    <label for="{{str_slug($data->name)}}"
                                           class="method {{str_slug($data->name)}} m-2">
                                        <div class="card-logos">
                                            <img src="{{asset('public/images/gateways/'.$data->image)}}"
                                                 id="{{str_slug($data->name)}}" class="w-40p"/>
                                        </div>

                                        <div class="radio-input">
                                            <input id="{{str_slug($data->name)}}" type="radio"
                                                   data-id="{{$data->id}}"
                                                   data-min_amount="{{round($data->min_amount,2)}}"
                                                   data-max_amount="{{round($data->max_amount,2)}}"
                                                   data-percent_charge="{{round($data->percent_charge,2)}}"
                                                   data-fixed_charge="{{round($data->fixed_charge,2)}}"
                                                   name="payment">
                                            @lang('Deposit Via') {{$data->name}}
                                        </div>
                                    </label>
                                </div>
                            @endforeach

                        </div>


                        <div class="row ">


                            <div class="col-md-6 ">

                                    <div class="card-body my-5">

                                        <span class="deposit-limit text-danger"></span><br>
                                        <span class="deposit-charge  text-danger"></span>
                                        <div class="form-row align-items-center ">
                                            <div class="col-auto">
                                                <div class="md-form">
                                                    <label for="Amount" class="font-weight-bold"> @lang('Enter Amount')</label>
                                                    <input type="text" class="form-control amount mb-2" placeholder="0.00"
                                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                                    <label class="sr-only" for="inlineFormInputMD">Amount</label>

                                                </div>
                                            </div>


                                            <div class="col-auto">
                                                <div class="md-form ">
                                                    <button type="button" class="btn btn-dark  mt-4 request-button">Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>

                            <div class="col-md-6 ">

                                <div class="card-body my-5 result-show">

                                </div>
                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>


@stop




@section('js')
    <script src="{{asset('public/js/axios.min.js')}}"></script>

    <script>

        (function ($) {
            "use strict";

            $(document).ready(function () {

                var gatewayId = null;
                $('.deposit-limit').hide();
                $('.deposit-charge').hide();

                $('.method').on('click', function () {
                    $('.method').removeClass('blue-border');
                    $('.method').find('input[name="payment"]').prop('checked', false);
                    $(this).addClass('blue-border');
                    $(this).find('input[name="payment"]').prop('checked', true);

                    var gateway = $(this).find('input[name="payment"]').data();
                    gatewayId = gateway.id;
                    $('.result-show').hide();

                    $(".deposit-limit").text(`@lang('Deposit Limit:') ${gateway.min_amount} - ${gateway.max_amount} {{$basic->currency}} `)
                    $('.deposit-charge').text(`@lang('Deposit Charge:') ${gateway.fixed_charge} {{$basic->currency}} + ${gateway.percent_charge} % `)
                    $('.deposit-limit').show()
                    $('.deposit-charge').show()
                });

                $('.amount').on('keypress', function () {
                    $('.result-show').hide();
                });

                $('.request-button').on('click', function () {
                    axios({
                        method: 'post',
                        url: '{{route('make-request')}}',
                        data: {
                            gateway_id: gatewayId,
                            amount: $('.amount').val()
                        }
                    }).then(function (response) {

                        // Error Part
                        if (response.data.errors && 0 < response.data.errors.length) {
                            response.data.errors.forEach(function (item, index) {
                                var content = {};
                                content.message = item;
                                content.title = 'Warning!';
                                content.icon = 'fa fa-bell';

                                $.notify(content, {
                                    type: 'danger',
                                    placement: {
                                        from: 'top',
                                        align: 'right'
                                    },
                                    showProgressbar: true,
                                    time: 1000,
                                    delay: 4000,
                                });
                            });
                        } else {
                            if (response.data.success == true) {
                                var logs = response.data.logs;
                                if(1000 >logs.method_code){
                                    var route = "{{route('deposit-confirm')}}";
                                }else{
                                    var route = "{{route('deposit.manual.confirm')}}";
                                }


                                var output = `
                                    <ul class="list-group font-weight-bold text-center">
                                        <li class="list-group-item ">Payment Method : ${logs.method}</li>
                                        <li class="list-group-item ">${logs.amount}</li>
                                        <li class="list-group-item">${logs.conversion_rate}</li>
                                        <li class="list-group-item">${logs.in}</li>
                                        <li class="list-group-item">${logs.charge}</li>
                                        <li class="list-group-item">${logs.payable}</li>
                                        <li class="list-group-item">
                                            <a href="${route}" class="btn btn-success">Pay Now</a>
                                        </li>
                                    </ul>`;

                                $('.result-show').html(output)
                            } else {
                                $('.result-show').html(null)
                            }
                            $('.result-show').show();
                        }
                    });
                });

            });

        })(jQuery);


    </script>
@stop
