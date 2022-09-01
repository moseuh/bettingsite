@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-wallet"></i>
              </span> {{$page_title}} </h3>
    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title mb-5">
                        Edit {{$page_title}}
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic">
                                <a href="{{route('withdraw-method')}}"
                                   class="btn btn-sm btn-outline-success   active ">
                                    <i class="mdi mdi-view-list"></i> All List
                                </a>
                            </div>
                        </div>
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('errors.error')
                            <form class="forms-sample" role="form" action="{{route('withdraw-method.update',$gateway)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')


                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Method Name</label>
                                            <input type="text" name="name" value="{{$gateway->name}}"   class="form-control" id="name" placeholder="Method Name" >
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration" class="font-weight-bold">Duration</label>

                                            <div class="input-group">

                                                <input type="text" name="duration" value="{{$gateway->duration}}"   class="form-control" id="duration" placeholder="Duration">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">Hour / Minutes/ Days</span>
                                                </div>
                                            </div>

                                            @if ($errors->has('duration'))
                                                <p class="text-danger">{{ $errors->first('duration') }}</p>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="withdraw_min" class="font-weight-bold">Minimum Amount</label>
                                            <div class="input-group">
                                                <input type="text" name="withdraw_min" value="{{round($gateway->withdraw_min,2)}}"   class="form-control" id="withdraw_min" placeholder="Minimum Amount">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('withdraw_min'))
                                                <p class="text-danger">{{ $errors->first('withdraw_min') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="withdraw_max" class="font-weight-bold">Maximum Amount</label>
                                            <div class="input-group">
                                                <input type="text" name="withdraw_max" value="{{round($gateway->withdraw_max,2)}}"   class="form-control" id="withdraw_max" placeholder="Maximum Amount">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('withdraw_max'))
                                                <p class="text-danger">{{ $errors->first('withdraw_max') }}</p>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="percent" class="font-weight-bold">Percent Charge</label>
                                            <div class="input-group">
                                                <input type="text" name="percent" value="{{round($gateway->percent,2)}}"   class="form-control" id="percent" placeholder="Percent Charge">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">%</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('percent'))
                                                <p class="text-danger">{{ $errors->first('percent') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fix" class="font-weight-bold">Fixed Charge</label>
                                            <div class="input-group">
                                                <input type="text" name="fix" value="{{round($gateway->fix,2)}}"   class="form-control" id="fix" placeholder="Fixed Charge">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('fix'))
                                                <p class="text-danger">{{ $errors->first('fix') }}</p>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="font-weight-bold">Status</label>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="status" class="form-check-input" @if($gateway->status == 1) checked @endif>  Active <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <a href="#0" class="btn btn-success float-right mb-3" id="generate"><i
                                                        class="fa fa-plus-circle"></i> Add Field</a>
                                        </div>
                                    </div>
                                </div>

                                    <div class="row addedField">



                                        @if($gateway->input_form != null)
                                            @foreach($gateway->input_form as $k => $v)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="input-group">

                                                            <input name="field_name[]" class="form-control form-control-lg" type="text" value="{{$v->field_level}}" required placeholder="Field Name">

                                                            <select name="type[]"  class="form-control  form-control-lg">
                                                                <option value="text" @if($v->type == 'text') selected @endif>Input Text</option>
                                                                <option value="textarea" @if($v->type == 'textarea') selected @endif>Textarea</option>
                                                                <option value="file" @if($v->type == 'file') selected @endif>File upload</option>
                                                            </select>

                                                            <select name="validation[]"  class="form-control  form-control-lg">
                                                                <option value="required" @if($v->validation == 'required') selected @endif>Required</option>
                                                                <option value="nullable" @if($v->validation == 'nullable') selected @endif>Optional</option>
                                                            </select>

                                                            <span class="input-group-btn">
                                                                <button class="btn btn-danger btn-lg delete_desc" type="button">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>








                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            @if($gateway->image == null)
                                                <div class="fileinput-new thumbnail w-215 h-215"  data-trigger="fileinput">
                                                    <img class="w-215" src="{{ asset('public/images/user/default.jpg') }}/" alt="...">
                                                </div>
                                            @else
                                                <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                    <img class="w-215" src="{{ asset('public/images/withdraw/') }}/{{$gateway->image}}" alt="...">
                                                </div>
                                            @endif

                                            <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215"></div>
                                            <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>

                                        @if ($errors->has('image'))
                                            <p class="text-danger">{{ $errors->first('image') }}</p>
                                        @endif

                                    </div>
                                </div>




                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection

@section('script')
    <script>
        (function ($) {
            "use strict";

            $(document).ready(function () {
                $("#generate").on('click', function () {
                    var form = `
            <div class="col-md-12">
                <div class="form-group">
                    <div class="input-group">

                        <input name="field_name[]" class="form-control form-control-lg" type="text" required placeholder="Field Name">

                        <select name="type[]"  class="form-control  form-control-lg">
                            <option value="text">Input Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="file">File upload</option>
                        </select>

                        <select name="validation[]"  class="form-control  form-control-lg">
                            <option value="required">Required</option>
                            <option value="nullable">Optional</option>
                        </select>

                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-lg delete_desc" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div> `;

                    $('.addedField').append(form)
                });


                $(document).on('click', '.delete_desc', function () {
                    $(this).closest('.input-group').remove();
                });
            });

        })(jQuery);
    </script>
@stop
