@extends('user')

@section('load-css')

    <link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-fileinput.css')}}">
@stop
@section('content')


    @include('partials.breadcrumb')

    <div class="faq-section smoke-bg">
        <div class="container">


               <div class="row">
                   <div class="col-md-12">
                       @if ($errors->any())
                           @foreach ($errors->all() as $error)
                               <div>{{$error}}</div>
                           @endforeach
                       @endif
                   </div>

                       <div class="col-md-12 mb-4">
                           <div class="card card-deposit card-border-1p">
                               <div class="card-header custom-header text-center">
                                   <h4 class="card-title">@lang('Additional Information To Withdraw Confirm')</h4>
                               </div>
                               <div class="card-body card-body-deposit">

                                   <div class="row">
                                       <div class="col-md-4">
                                           <ul class="list-group">
                                               <li class="list-group-item font-weight-bold">
                                                   <img src="{{asset('public/images/withdraw/'. $withdraw->method->image)}}" class="card-img-top w-100p" alt="{{$withdraw->method->name}}" >

                                               </li>
                                               <li class="list-group-item font-weight-bold">@lang('Request Amount') : <span class="float-right text-success">{{formatter_money($withdraw->amount)}} {{$basic->currency_sym}}</span></li>
                                               <li class="list-group-item font-weight-bold">@lang('Charge Amount') : <span class="float-right text-danger">{{formatter_money($withdraw->charge)}} {{$basic->currency_sym}}</span></li>
                                               <li class="list-group-item font-weight-bold">@lang('Total Payable') : <span class="float-right text-danger">{{formatter_money($withdraw->net_amount)}} {{$basic->currency_sym}}</span></li>
                                               <li class="list-group-item font-weight-bold">@lang('Available Balance') : <span class="float-right text-success">{{formatter_money(Auth::user()->balance - $withdraw->net_amount)}} {{$basic->currency_sym}}</span></li>
                                           </ul>
                                       </div>


                                       <div class="col-md-8 mt-3">

                                           <form action="" method="post" enctype="multipart/form-data">
                                               @csrf
                                           @foreach($withdraw->method->input_form as $k => $v)
                                               @if($v->type == "text")
                                                   <div class="form-group">
                                                       <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                       <input type="text" name="{{$k}}" class="form-control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                       @if ($errors->has($k))
                                                           <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                       @endif
                                                   </div>
                                               @elseif($v->type == "textarea")
                                                   <div class="form-group">
                                                       <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                       <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                       @if ($errors->has($k))
                                                           <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                       @endif
                                                   </div>
                                               @elseif($v->type == "file")

                                                   <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                   <div class="form-group">
                                                       <div class="fileinput fileinput-new " data-provides="fileinput">
                                                           <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                                data-trigger="fileinput">
                                                               <img class="w-200" src="{{ asset('public/images/user/default.jpg') }}" alt="...">
                                                           </div>
                                                           <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>

                                                           <div class="img-input-div">
                                                                <span class="btn btn-info btn-file">
                                                                    <span class="fileinput-new "> @lang('Select') {{$v->field_level}}</span>
                                                                    <span class="fileinput-exists"> @lang('Change')</span>
                                                                    <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                                </span>
                                                               <a href="#" class="btn btn-danger fileinput-exists"
                                                                  data-dismiss="fileinput"> @lang('Remove')</a>
                                                           </div>

                                                       </div>
                                                       @if ($errors->has($k))
                                                           <br>
                                                           <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                       @endif
                                                   </div>
                                               @endif
                                           @endforeach

                                               <div class=" form-group">
                                                   <div class="form-element mt-2">
                                                       <button type="submit" class="btn btn-block"><span>@lang('Confirm Now')</span>
                                                       </button>
                                                   </div>
                                               </div>

                                           </form>



                                       </div>
                                   </div>

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
