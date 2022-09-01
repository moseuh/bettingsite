@extends('layout')

@section('css')

@stop
@section('content')

@include('partials.breadcrumb')


<div class="project-details">
    <div class="container">
        <div class="row ">
            <div class="col-xl-12 col-lg-12">
                <div class="left-side">

                    <div class="part-text-top">
                        <h2 class="subtitle">{{__($page_title)}}</h2>
                        <p><?php echo  $basic->about;?></p>
                    </div>

                </div>
            </div>
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
                                <?php echo  $data->details; ?>
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


<!--  testimonial section start  -->
<div class="testimonial-section home-3 pb-5 smoke_bg " >
    <div class="container">
        <div class="section-title">
            <span>{{$basic->testimonial_title}}</span>
            <h2>{{$basic->testimonial_subtitle}}</h2>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="testimonial-carousel-3 owl-carousel owl-theme">
                    @foreach($testimonials as $data)
                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                @if($data->image == null)
                                    <img src="{{ asset('public/images/user/default.jpg') }}" class="w-80" alt="{{$data->name}}">
                                @else
                                    <img src="{{ asset('public/images/testimonial/'.$data->image)}}" alt="{{$data->name}}">
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
    </div>

    <div class="testimonial-section-overlay"></div>
</div>
<!--  testimonial section end  -->


<!--   partner section start    -->
<div class="partner-section section-padding pt-5">
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

@stop

@section('js')

@stop
