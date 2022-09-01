@extends('user')

@section('load-css')
    <link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-fileinput.css')}}">
@stop
@section('css')
@stop
@section('content')

    @include('partials.breadcrumb')

    <div class="faq-section ">
        <div class="container">


            <div class="row">
                <div class="col-md-12">
                    <div class="card smoke-bg">
                        <div class="card-body">
                            <form action="{{route('deposit.manual.update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @php
                                        $extra = $method->extra;
                                    @endphp

                                    <div class="col-md-12 text-center">
                                        <h4 class="text-center text-white mb-4">@lang('Please follow the instruction below')</h4>

                                        <p class="text-center mt-2 text-white" >@lang('You have requested to deposit ') <b
                                                class="text-success">{{ getAmount($data['amount'])  }} {{$basic->currency}}</b> @lang(', Please pay ')
                                            <b class="text-success">{{getAmount($data['final_amo']) .' '.$data['method_currency'] }}</b> @lang(' for successful payment')
                                        </p>

                                        <p class="my-4 text-center text-white manual-desc">@php echo  $method->description @endphp</p>
                                        <p class="text-center text-white my-3 font-weight-bold">@lang('Delay:') @php echo  $extra->delay @endphp</p>

                                    </div>
                                    <div class="col-md-12">

                                        @include('errors.error')

                                    </div>

                                    @if($method->parameter)

                                        @foreach(json_decode($method->parameter) as $k => $v)
                                            @if($v->type == "text")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-white"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <input type="text" class="form-control form-control-lg" name="{{$k}}"  value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == 'required') required @endif>
                                                    </div>
                                                </div>
                                            @elseif($v->type == "textarea")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-white"><strong>{{__(inputTitle($v->field_level))}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == 'required') required @endif>{{old($k)}}</textarea>

                                                    </div>
                                                </div>
                                            @elseif($v->type == "file")
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="text-white"><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                        <br>

                                                        <div class="fileinput fileinput-new " data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                                 data-trigger="fileinput">
                                                                <img style="max-width: 220px; max-height: 220px" src="{{ asset(imagePath()['image']['default']) }}" alt="..." >
                                                            </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>

                                                            <div class="img-input-div">
                                                                <span class="btn btn-info btn-file">
                                                                    <span class="fileinput-new "> @lang('Select') {{$v->field_level}}</span>
                                                                    <span class="fileinput-exists"> @lang('Change')</span>
                                                                    <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == 'required') required @endif>
                                                                </span>
                                                                <a href="#" class="btn btn-danger fileinput-exists"
                                                                   data-dismiss="fileinput"> @lang('Remove')</a>
                                                            </div>

                                                        </div>



                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach

                                    @endif


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit"
                                                    class="btn btn-success cartbtn   btn-block mt-2 text-center">@lang('Pay Now')</button>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop

@section('load-js')
    <script src="{{asset('public/admin/js/bootstrap-fileinput.js')}}"></script>
@stop
