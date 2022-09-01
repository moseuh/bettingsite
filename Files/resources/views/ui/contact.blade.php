@extends('layout')

@section('css')

@stop
@section('content')

@include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="contact-section">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="part-text-top">
                            <h2 class="subtitle">{{__($page_title)}}</h2>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <form action="{{route('contact.submit')}}" method="post">
                            @csrf
                            <div class="row">
                                @include('errors.error')
                                <div class="col-md-12">
                                    <div class="form-element"><input type="text" name="name" placeholder="Name" required></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element"><input type="email" name="email" placeholder="Email" required></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element"><input type="text" name="subject" placeholder="Subject"></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <textarea name="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit"><span>Submit</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-infos">
                            <div class="row no-gutters">
                                <div class="col-lg-12 single-info-col">
                                    <div class="single-info wow fadeInRight" data-wow-duration="1s">
                                        <div class="icon-wrapper"><i class="fas fa-home"></i></div>
                                        <div class="info-txt">
                                            <p>{{$basic->address}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 single-info-col">
                                    <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".2s">
                                        <div class="icon-wrapper"><i class="fas fa-phone"></i></div>
                                        <div class="info-txt">
                                            <p>{{$basic->phone}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 single-info-col">
                                    <div class="single-info wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
                                        <div class="icon-wrapper"><i class="far fa-envelope"></i></div>
                                        <div class="info-txt">
                                            <p>{{$basic->email}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  contact form and map end  -->
        </div>
    </div>
    <!--   contact section end    -->


@stop

@section('js')

@stop
