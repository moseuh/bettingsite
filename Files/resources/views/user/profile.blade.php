@extends('user')

@section('load-css')
    <link rel="stylesheet" href="{{asset('public/admin/css/bootstrap-fileinput.css')}}">
@stop
@section('content')
    @include('partials.breadcrumb')

    <!--   contact section start    -->
    <div class="contact-section ">
        <div class="container">
            <!--  contact form and map start  -->
            <div class="contact-form-section">
                <div class="row justify-content-center">
                    <div class="col-lg-12">

                        <div class=" smoke-bg p-5 px-3">

                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="row ">

                                <div class="col-sm-3">
                                    <div class="form-element">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            @if(Auth::user()->image == null)
                                                <div class="fileinput-new thumbnail w-215 h-215"data-trigger="fileinput">
                                                    <img class="w-215"
                                                         src="{{ asset('public/images/user/user-default.jpg') }}/"
                                                         alt="...">
                                                </div>
                                            @else
                                                <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                    <img class="w-215"
                                                         src="{{ asset('public/images/user/') }}/{{Auth::user()->image}}"
                                                         alt="...">
                                                </div>
                                            @endif

                                            <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215"></div>
                                            <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                                class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                                class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists bold uppercase"
                                                   data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>

                                        @if ($errors->has('image'))
                                            <p class="text-danger">{{ $errors->first('image') }}</p>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-9">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="first_name" class="font-weight-bold  text-white">@lang('First Name')</label>
                                               <input type="text" name="first_name" placeholder="@lang('First Name')" value="{{$user->first_name}}">
                                               @if ($errors->has('first_name'))
                                                   <span class="text-danger">{{ __($errors->first('first_name')) }}</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="last_name" class="font-weight-bold  text-white">@lang('Last Name')</label>
                                               <input type="text" name="last_name" placeholder="@lang('Last Name')" value="{{$user->last_name}}">
                                               @if ($errors->has('last_name'))
                                                   <span class="text-danger">{{ __($errors->first('last_name')) }}</span>
                                               @endif
                                           </div>
                                       </div>

                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="username" class="font-weight-bold  text-white">@lang('Username')</label>
                                               <input type="text" name="username" placeholder="@lang('Username')" value="{{$user->username}}">
                                               @if ($errors->has('username'))
                                                   <span class="text-danger">{{ __($errors->first('username')) }}</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="city" class="font-weight-bold  text-white">@lang('City')</label>
                                               <input type="text" name="city" placeholder="@lang('City')" value="{{$user->city}}">
                                               @if ($errors->has('city'))
                                                   <span class="text-danger">{{ __($errors->first('city')) }}</span>
                                               @endif
                                           </div>
                                       </div>

                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="zip_code" class="font-weight-bold  text-white">@lang('Zip Code')</label>
                                               <input type="text" name="zip_code" placeholder="@lang('Zip Code')" value="{{$user->zip_code}}">
                                               @if ($errors->has('zip_code'))
                                                   <span class="text-danger">{{ __($errors->first('zip_code')) }}</span>
                                               @endif
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-element">
                                               <label for="address" class="font-weight-bold  text-white">@lang('Address')</label>
                                               <input type="text" name="address" placeholder="@lang('Address')"
                                                      value="{{$user->address}}">
                                               @if ($errors->has('address'))
                                                   <span class="text-danger">{{ __($errors->first('address')) }}</span>
                                               @endif
                                           </div>
                                       </div>


                                   </div>
                                </div>


                            </div>


                            <div class="row mt-4">

                                <div class="col-md-12">
                                    <div class="form-element">
                                        <button type="submit" class="btn btn-block"><span>@lang('Submit')</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
            <!--  contact form and map end  -->
        </div>
    </div>
    <!--   contact section end    -->
@stop


@section('load-js')
    <script src="{{asset('public/admin/js/bootstrap-fileinput.js')}}"></script>
@stop

