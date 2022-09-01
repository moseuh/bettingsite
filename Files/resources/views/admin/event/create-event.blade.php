@extends('admin.layout.master')

@section('css')

@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-trophy-outline "></i>
              </span>
            {{$page_title}}
        </h3>
    </div>


    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">
                    <h4 class="card-title mb-5">
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{route('admin.matches')}}" class="btn btn-sm btn-outline-success @if(Request::routeIs('admin.matches')) active @endif">
                                    <i class=" mdi mdi-eye "></i> All Event
                                </a>
                            </div>
                        </div>
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form class="forms-sample" action="" method="post">
                                @csrf

                                <div class="form-group  row">
                                    <label for="tournament" class="col-sm-3 col-form-label"><strong>Select Tournament</strong></label>
                                    <div class="col-sm-9">
                                        <select name="event_id" id="tournament" class="form-control">
                                            <option value="">Select Tournament</option>
                                            @foreach($events as $data)
                                                <option value="{{$data->id}}">{{$data->name}}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('event_id'))
                                            <div class="text-danger">{{ $errors->first('event_id') }}</div>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="eventName" class="col-sm-3 col-form-label"><strong>Event Name</strong></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control" id="eventName"
                                               placeholder="Event Name">
                                        @if ($errors->has('name'))
                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="eventName" class="col-sm-3 col-form-label"><strong>Start Date & Time</strong></label>
                                    <div class="col-sm-5">

                                        <div id="datepicker-popup" class="input-group date datepicker">
                                            <input type="text" name="start_date" class="form-control" autocomplete="off">
                                            <span class="input-group-addon input-group-append border-left">
                                                <span class="mdi mdi-calendar input-group-text"></span>
                                              </span>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('start_date') }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group date" id="timepicker-example" data-target-input="nearest">
                                            <div class="input-group" data-target="#timepicker-example" data-toggle="datetimepicker">
                                                <input type="text" name="start_time" class="form-control datetimepicker-input" data-target="#timepicker-example" autocomplete="off" />
                                                <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                            </div>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('start_time') }}</p>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="eventName" class="col-sm-3 col-form-label"><strong>End Date & Time</strong></label>
                                    <div class="col-sm-5">
                                        <div id="datepicker-popup2" class="input-group date datepicker">
                                            <input type="text" name="end_date" class="form-control" autocomplete="off">
                                            <span class="input-group-addon input-group-append border-left">
                                                <span class="mdi mdi-calendar input-group-text"></span>
                                              </span>
                                        </div>
                                        <p class="text-danger">{{ $errors->first('end_date') }}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group date" id="timepicker-example2" data-target-input="nearest">
                                            <div class="input-group" data-target="#timepicker-example2" data-toggle="datetimepicker">
                                                <input type="text" name="end_time" class="form-control datetimepicker-input" data-target="#timepicker-example"  autocomplete="off"/>
                                                <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                            </div>
                                        </div>

                                        <p class="text-danger">{{ $errors->first('end_time') }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="eventName" class="col-sm-3 col-form-label"><strong>Status</strong></label>
                                    <div class="col-sm-9">

                                        <input type="checkbox" name="status" data-toggle="toggle" data-on="<i class='fa fa-eye'></i> Enabled" data-off="<i class='fa fa-eye-slash'></i> Disabled" data-onstyle="primary" data-offstyle="danger">
                                    </div>

                                </div>




                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Save</button>
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


            if ($("#timepicker-example").length) {
                $('#timepicker-example').datetimepicker({
                    format: 'LT'
                });
            }
            if ($("#datepicker-popup").length) {
                $('#datepicker-popup').datepicker({
                    enableOnReadonly: true,
                    todayHighlight: true,
                });
            }

            if ($("#timepicker-example2").length) {
                $('#timepicker-example2').datetimepicker({
                    format: 'LT'
                });
            }
            if ($("#datepicker-popup2").length) {
                $('#datepicker-popup2').datepicker({
                    enableOnReadonly: true,
                    todayHighlight: true,
                });
            }

            if ($(".datepicker-autoclose").length) {
                $('.datepicker-autoclose').datepicker({
                    autoclose: true
                });
            }

        })(jQuery);

    </script>
@stop
