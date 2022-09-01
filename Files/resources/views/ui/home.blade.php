@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('public/templates/css/custom.css')}}">
    <style>
        @foreach($sliders as $data)
        .hero-bg-{{$data->id}}    {
            background-image: url({{asset('public/images/slider/'.$data->image)}});
            background-size: cover;
            background-position: center;
        }
        @endforeach
    </style>
@stop
@section('content')

    <script>
        function createCountDown(elementId, sec) {
            var tms = sec;
            var x = setInterval(function() {
                var distance = tms*1000;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById(elementId).innerHTML =days+"D  "+ hours + "h "+ minutes + "m " + seconds + "s ";
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById(elementId).innerHTML = "{{__('COMPLETE')}}";
                }
                tms--;
            }, 1000);
        }

    </script>

    <!--  Hero Area Start  -->
    <div class="hero-area home-3">
        <div class="hero-carousel owl-carousel owl-theme">

            @foreach($sliders as $data)
                <div class="single-hero-item hero-bg-{{$data->id}}">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-10">
                                <div class="hero-txt">
                                    <h1>{{$data->title}}</h1>
                                </div>
                            </div>
                            <div class="col-lg-5"></div>
                        </div>
                    </div>
                    <div class="hero-overlay"></div>
                </div>
            @endforeach
        </div>
    </div>
    <!--  Hero Area End  -->


    <div class="vehicles-area home-2">
        <div class="container">
            <div class="section-title">
                <h2>@lang('PREDICT NOW')</h2>
            </div>
            <div class="row ">
                @include('errors.error')
                @foreach($matches as $match)
                    <div class="col-lg-12 mb-3">
                        <!-- Heading Component-->
                        <article class="heading-component ">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">{{$match->event->name}}
                                </h5>
                                <span> {{date('d M, Y', strtotime($match->start_date))}}</span>
                            </div>
                        </article>

                        <div class="sport-table-header">
                            <p>{{$match->name}}
                                <span class="float-right site-color  countdown "  id="counter{{$match->id}}" ></span>
                            </p>
                            <script>createCountDown('counter<?php echo $match->id ?>', {{\Carbon\Carbon::parse($match->end_date)->diffInSeconds()}});</script>
                        </div>

                        @php
                            $now = Carbon\Carbon::now();
                            $questions = App\BetQuestion::with('match')->whereMatch_id($match->id)->whereStatus(1)->where('end_time','>=', $now)->latest()->get();
                        @endphp


                        @if(count($questions) > 0)
                            @foreach($questions as $question)
                                @php
                                    $betOptions = App\BetOption::with('match','question')->whereQuestion_id($question->id)->whereStatus(1)->latest()->get();
                                @endphp
                                @if(count($betOptions)>0)
                                    <div class="sport-table">
                                        <div class="sport-table-tr">
                                            <div class="row sport-row align-items-center justify-content-center">
                                                <div class="col-md-1 col-lg-1">
                                                    <div class="sport-table-icon">
                                                    </div>
                                                </div>



                                                <div class="col-md-4 col-lg-3">
                                                    <div class="sport-table-title">
                                                        <div class="sport-table-title-item sport-table-title-item-left">
                                                            <span class="sport-table-title-team">  {{$question->question}}</span>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-7">
                                                    <div class="sport-table-wager">
                                                        @foreach($betOptions as $data)

                                                            <div class="progress-button-item sport-table-wager-button m-0">
                                                                <a class="bet_button text-decoration-none"
                                                                   href="#0"
                                                                   data-toggle="modal" data-target="#sportModal"
                                                                   data-team-name="{{$data->option_name}}"
                                                                   data-confrontation="{{$question->match->name}}"
                                                                   data-id="{{$data->id}}"
                                                                   data-minamo="{{$data->min_amo}}"
                                                                   data-macthid="{{$question->match->id}}"
                                                                   data-ratioone="{{$data->ratio1}}"
                                                                   data-ratiotwo="{{$data->ratio2}}"
                                                                   data-betlimit="{{$data->bet_limit}}"
                                                                   data-questionid="{{$question->id}}"
                                                                   data-wager-count="{{$data->ratio1}} : {{$data->ratio2}}">
                                                                    <span>{{$data->option_name}}</span>
                                                                    <span class="sport-table-wager-button-count">{{$data->ratio1}}
                                                                        : {{$data->ratio2}}</span>
                                                                </a>

                                                                @php
                                                                   $percent =  percent($data->totalInvestByOptions(), $question->totalInvest())
                                                                @endphp
                                                                <div class="progress">
                                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$percent}}%;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100">{{$percent}}%</div>
                                                                </div>
                                                            </div>


                                                        @endforeach

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        @else
                            <div class="sport-table">
                                <div class="sport-table-tr">
                                    <div class="row sport-row align-items-center ">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <div class="sport-table-icon">
                                                <p class="text-center">@lang('No question available')</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <section class="about-area about-bg" id="about">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-white text-uppercase">
                        <h2>@lang('ABOUT') {{__($basic->sitename)}}</h2>
                    </div>
                </div>
            </div>
            <div class="row">

                @foreach($howItWork as $k => $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-about-box-item">
                            <div class="icon">
                                <?php echo  $data->icon?>
                            </div>
                            <div class="content">
                                <h3>{{$data->title}}</h3>
                                <p>
                                    {{$data->details}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>




    <!--  Statistics Area Start  -->
    <div class="statistics-area">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-statistic">
                        <div class="icon-wrapper"><i class="fa fa-users"></i></div>
                        <div class="count">
                            <h2><span class="counter">{{number_format($users)}}</span> +</h2>
                        </div>
                        <span class="title">@lang('Total User')</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-statistic">
                        <div class="icon-wrapper"><i class="fas fa-hand-point-up"></i></div>
                        <div class="count">
                            <h2><span class="counter">{{number_format($totalPrediction)}}</span> +</h2>
                        </div>
                        <span class="title">@lang('Total Prediction')</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-statistic">
                        <div class="icon-wrapper"><i class="fas fa-wallet"></i></div>
                        <div class="count">
                            <h2><span class="counter">{{number_format(count($gateway))}}</span> +</h2>
                        </div>
                        <span class="title">@lang('Total Gateways')</span>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-statistic">
                        <div class="icon-wrapper"><i class="fas fa-hand-holding-usd"></i></div>
                        <div class="count">
                            <h2><span class="counter">{{$withdraw}}</span> +</h2>
                        </div>
                        <span class="title">@lang('Withdraw Method')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Statistics Area End  -->



    <div class="transaction_wrapper float_left smoke_bg ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="section-title ">
                        <h2>@lang('Leader Board')</h2>
                    </div>

                    <div class="x_offer_tabs_wrapper index3_offer_tabs">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#home"> @lang('Weekly')</a>
                            </li>
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab"
                                                    href="#menu2">@lang('All Time')</a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="tab-content">
                        <div id="home" class="tab-pane">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table_next_race index3_table_race league_table overflow-scroll">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th data-scope="col">@lang('Name')</th>
                                                <th data-scope="col">@lang('Prediction')</th>
                                                <th data-scope="col">@lang('Amount')</th>
                                            </tr>

                                            @foreach($weeklyLeader as $k => $data)
                                                <tr>

                                                    <td data-label="@lang('User')">
                                                        @if($data->user->image == null)
                                                            <img src="{{asset('public/images/user/user-default.jpg')}}" class="leader-img" alt="{{$data->user->username}}">
                                                        @else
                                                            <img src="{{asset('public/images/user/'.$data->user->image)}}" class="leader-img" alt="{{$data->user->username}}">
                                                        @endif
                                                        <span class="font-weight-bold">{{$data->user->username}}</span>
                                                    </td>

                                                    <td data-label="@lang('Prediction')"><span class="font-weight-bold">{{$data->total_predictions}} @lang('Times')</span></td>
                                                    <td data-label="@lang('Amount')"><span class="font-weight-bold">{{$basic->currency_sym}} {{number_format($data->investAmount,$basic->decimal)}}</span></td>

                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade active show">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="table_next_race index3_table_race league_table overflow-scroll">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <th data-scope="col">@lang('Name')</th>
                                                <th data-scope="col">@lang('Prediction')</th>
                                                <th data-scope="col">@lang('Amount')</th>

                                            </tr>

                                            @foreach($leader as $k => $data)
                                                <tr>

                                                    <td data-label="@lang('User')">
                                                        @if($data->user->image == null)
                                                            <img src="{{asset('public/images/user/user-default.jpg')}}" class="leader-img" alt="{{$data->user->username}}">
                                                        @else
                                                            <img src="{{asset('public/images/user/'.$data->user->image)}}" class="leader-img" alt="{{$data->user->username}}">
                                                        @endif
                                                        <span class="font-weight-bold">{{$data->user->username}}</span>
                                                    </td>

                                                    <td data-label="@lang('Prediction')"> <span class="font-weight-bold">{{$data->total_predictions}} @lang('Times')</span></td>
                                                    <td data-label="@lang('Amount')"><span class="font-weight-bold">{{$basic->currency_sym}} {{number_format($data->investAmount,$basic->decimal)}}</span></td>

                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>






    <!--  testimonial section start  -->
    <div class="testimonial-section home-3 py-5 smoke_bg ">
        <div class="container">
            <div class="section-title">
                <h2>{{$basic->testimonial_subtitle}}</h2>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="testimonial-carousel-3 owl-carousel owl-theme">
                        @foreach($testimonials as $data)
                            <div class="single-testimonial">
                                <div class="img-wrapper">

                                    @if($data->image == null)
                                        <img src="{{ asset('public/images/user/default.jpg') }}" class="w-80"
                                             alt="{{$data->name}}">
                                    @else

                                        <img src="{{ asset('public/images/testimonial/'.$data->image)}}"
                                             alt="{{$data->name}}">
                                    @endif


                                </div>
                                <div class="client-desc">
                                    <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                    <p class="comment">{{$data->details}}</p>
                                    <h5 class="name">{{$data->name}}</h5>
                                    <p class="rank">{{$data->designation}}</p>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>

            <div class="testimonial-section-overlay"></div>
        </div>

    </div>
    <!--  testimonial section end  -->



    <section class="blog-area gray-bg pt-5">
        <div class="container">

            <div class="section-title mt-5">
                <span>{{__($basic->blog_title)}}</span>
                <h2>{{__($basic->blog_subtitle)}}</h2>
            </div>

            <div class="row">
                @foreach($blogs as $data)
                    <div class="col-lg-6 col-md-6">
                        <div class="single-blog mt-30">
                            <img src="{{asset('public/images/blog/'.$data->image)}}" alt="{{$data->title}}">
                            <div class="blog-content">
                                <div class="blog-user-flex d-flex align-items-center">
                                    <div class="blog-user-info">
                                        <span>By Admin | {{date('d M, Y',strtotime($data->created_at))}}</span>
                                    </div>
                                </div>
                                <div class="blog-item">
                                    <h4 class="title">{{str_limit($data->title,50)}}</h4>
                                    <p>{{str_limit(strip_tags($data->details),120)}}</p>
                                    <a href="{{route('info',[str_slug($data->title), $data->id])}}">@lang('Read More ')
                                        <i class="flaticon-long-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <!--   partner section start    -->
    <div class="partner-section section-padding pt-5 smoke_bg">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-dark text-uppercase">
                        <h2>@lang('We Accept') </h2>
                    </div>
                </div>
            </div>

            <div class="row pb-5">
                <div class="col-md-12">
                    <div class="partner-carousel owl-carousel owl-theme">
                        @foreach($gateway as $data)
                            <div class="single-partner-item ">
                                <div class="outer-container">
                                    <div class="inner-container">
                                        <img src="{{asset('public/images/gateways/'.$data->image)}}" alt="{{$data->name}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   partner section end    -->


    <!--    Call to Action Area Start    -->
    <div class="cta-area cta-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10">
                    <h2>@lang('We Are Here To Help You Needs')</h2>
                </div>
                <div class="col-lg-2">
                    <a href="{{route('contact')}}" class="cartbtn cart">@lang('Contact Us')</a>
                </div>
            </div>
        </div>
        <div class="cta-overlay"></div>
    </div>
    <!--    Call to Action Area End    -->


    <div class="modal modal-sport fade" id="sportModal" tabindex="-1" role="dialog" aria-labelledby="sportModalTitle"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-sport-confrontation text-white font-20"
                        id="sportModalTitle">@lang('Prediction Now')</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('prediction')}}" method="post">
                    @csrf
                    <div class="modal-body text-center">
                        <p class="modal-sport-wager-title">
                            <span class="modal-sport-wager"></span>
                            <span class="modal-sport-wager-count"></span>
                        </p>

                        <p class="modal-sport-live">
                            <span class="font-weight-bold">@lang('MINIMUM PREDICT AMOUNT') <span
                                    class="minamo"></span> {{__($basic->currency)}}</span>
                        </p>
                        <div class="stepper-sport">
                            <div class='ctrl'>
                                <div class='ctrl__button ctrl__button--decrement'>&ndash;</div>
                                <div class='ctrl__counter'>
                                    <input name="invest_amount"
                                           class='ctrl__counter-input form-input  invest_amount_min ronnie_bet get_amount_for_ratio'
                                           maxlength='10' type='text' value='' min="" max=""
                                           onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                </div>
                                <div class='ctrl__button ctrl__button--increment'>+</div>
                            </div>
                        </div>


                        <input type="hidden" value="" name="betoption_id" id="betoption_id">
                        <input type="hidden" value="" name="match_id" id="match_id">
                        <input type="hidden" value="" name="betquestion_id" id="questionid">
                        <input class="ratio1" type="hidden" value="" id="ratioOne">
                        <input class="ratio2" type="hidden" value="" id="ratioTwo">
                        <input class="form-control input-lg ronnie_ratio" name="return_amount" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <small>(@lang('IF YOU WIN'))</small>
                        <p class="modal-sport-win">
                            <span class="font-weight-bold">@lang('RETURN AMOUNT')</span>
                            <span class="font-weight-bold"><span class="wining-rate"></span> {{$basic->currency}}</span>
                        </p>
                        <p class="text-danger">{{$basic->win_charge}}% @lang('Charge Apply From This Amount')
                            (@lang('IF YOU WIN')) </p>
                        <p class="text-success">@lang('Maximum') <span
                                class="betlimit"></span>{{$basic->currency}} @lang('Predict in this Option')  </p>

                        @if(Auth::user())
                            <div class="form-element mt-2">
                                <button type="submit"><span>@lang('Predict Now')</span>
                                </button>
                            </div>
                        @else
                            <div class="form-element mt-2">
                                <a href="{{route('login')}}" class="cartbtn cart">@lang('Predict Now')
                                </a>
                            </div>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@section('js')

    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {

                $(document).on('click', '.bet_button', function () {
                    var id = $(this).data('id');
                    var minamo = $(this).data('minamo');
                    var macthid = $(this).data('macthid');
                    var ratioone = $(this).data('ratioone');
                    var ratiotwo = $(this).data('ratiotwo');
                    var questionid = $(this).data('questionid');
                    var betlimit = $(this).data('betlimit');

                    $('#betoption_id').val(id);
                    $("#match_id").val(macthid);
                    $("#ratioOne").val(ratioone);
                    $("#ratioTwo").val(ratiotwo);
                    $("#questionid").val(questionid);

                    $(".get_amount_for_ratio").val(minamo);
                    $('.minamo').text(minamo);
                    $('.betlimit').text(betlimit);
                    $('.ctrl__counter-input').attr('value', minamo)
                    $('.ctrl__counter-input').attr('min', minamo)
                    $('.ctrl__counter-num').text(minamo)
                    $('.ctrl__counter-input').attr('max', betlimit)

                    var amount = $('.get_amount_for_ratio').val();
                    var ratio1 = $('.ratio1').val();
                    var ratio2 = $('.ratio2').val();
                    var finalRation = parseFloat((amount * ratio2) / ratio1).toFixed(2);
                    $('.ronnie_ratio').val(finalRation);
                    $('.wining-rate').text(finalRation);
                });


                $(document).on('keyup change click', '.get_amount_for_ratio', function () {
                    var amount = $('.get_amount_for_ratio').val();
                    var ratio1 = $('.ratio1').val();
                    var ratio2 = $('.ratio2').val();
                    var finalRation = parseFloat((amount * ratio2) / ratio1).toFixed(2);
                    $('.ronnie_ratio').val(finalRation);
                    $('.wining-rate').text(finalRation);
                });
            });

        })(jQuery);

    </script>
@stop
