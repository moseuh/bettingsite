@extends('admin.layout.master')

@section('import-css')
@stop
@section('css')

@stop

@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi  mdi-trophy-outline  "></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">

                    <h4 class="card-title mb-5">
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic">
                                <a href="#0"
                                   data-toggle="modal" data-target="#myModal"
                                   data-act="Add New"
                                   class="btn btn-sm btn-gradient-success   active ">
                                    <i class="mdi mdi-plus-circle"></i> Add Question
                                </a>
                            </div>
                        </div>
                    </h4>


                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Question</th>
                            <th scope="col">Status</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $k=>$data)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Question">{{$data->question }}</td>
                                <td data-label="Status">
                                    <label class="badge badge-gradient-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</label>
                                </td>
                                <td data-label="Action">



                                    <button type="button" class="btn btn-gradient-info btn-sm btn-rounded btn-icon  tooltip-styled edit_button"
                                            data-tooltip-content="Edit Question"

                                            data-toggle="modal" data-target="#editModal"
                                            data-act="Edit"
                                            data-name="{{$data->question}}"
                                            data-datetime="{{date('h:i A',strtotime($data->end_time))}}"
                                            data-enddate="{{date('m/d/Y',strtotime($data->end_time))}}"
                                            data-status="{{$data->status}}"
                                            data-id="{{$data->id}}"
                                            data-mid="{{$data->match_id}}">

                                        <i class="mdi mdi-pencil"></i>
                                    </button>



                                    @php
                                        $totalOptions = $data->options()->count();
                                    @endphp

                                    <a href="{{route('view.option', $data->id )}}"
                                       class="btn btn-gradient-primary btn-sm btn-rounded btn-icon text-decoration-none pt-12 tooltip-styled"
                                       data-tooltip-content="Options">
                                        @if($totalOptions < 10)
                                            @php echo  "<i class='mdi mdi-numeric-".$totalOptions."-box'></i>"; @endphp
                                        @else
                                            <span>{{$totalOptions}}</span>
                                        @endif
                                    </a>



                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="card-footer">
                    {{$questions->links()}}
                </div>
            </div>
        </div>


    </div>




    <!--Add Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="action_act"></span> Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{route('save.question')}}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Question</strong></label>
                            <input class="form-control input-lg " name="question" required="">

                            <input class="form-control input-lg" name="match_id" type="hidden" value="{{$match_id->id}}">
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                            <label><strong>End Date</strong></label>
                            </div>

                            <div class="col-sm-7">

                                <div id="datepicker-popup" class="input-group date datepicker">
                                    <input type="text" name="end_date" class="form-control" autocomplete="off">
                                    <span class="input-group-addon input-group-append border-left">
                                                <span class="mdi mdi-calendar input-group-text"></span>
                                              </span>
                                </div>
                                <p class="text-danger">{{ $errors->first('end_date') }}</p>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group date" id="timepicker-example" data-target-input="nearest">
                                    <div class="input-group" data-target="#timepicker-example" data-toggle="datetimepicker">
                                        <input type="text" name="end_time" class="form-control datetimepicker-input"  data-target="#timepicker-example" autocomplete="off"/>
                                        <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                    </div>
                                </div>

                                <p class="text-danger">{{ $errors->first('end_time') }}</p>
                            </div>
                            <div class="col-md-12">
                            <p class="text-danger">Date & Time must be set Before {{date('d M, Y H:i:s A', strtotime($match_id->end_date))}}</p>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="">
                                <strong>Status</strong>
                            </label>
                            <select name="status" class="form-control input-lg ronnie_status" required="" selected="selected">
                                <option value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>
                            </select>
                            <br>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn  btn-gradient-success">Save </button>
                        <button type="button" class="btn btn-gradient-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="action_act"></span> Edit Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{route('update.question')}}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>Question</strong></label>
                            <input class="form-control input-lg edit_question" name="question" required="">

                            <input class="form-control input-lg edit_id" name="id" type="hidden" value="">
                            <input class="form-control input-lg" name="match_id" type="hidden" value="{{$match_id->id}}">
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                            <label><strong>End Date</strong></label>
                            </div>

                            <div class="col-sm-7">

                                <div id="datepicker-popup2" class="input-group date datepicker">
                                    <input type="text" name="end_date" class="form-control edit_date" autocomplete="off">
                                    <span class="input-group-addon input-group-append border-left">
                                                <span class="mdi mdi-calendar input-group-text"></span>
                                              </span>
                                </div>
                                <p class="text-danger">{{ $errors->first('end_date') }}</p>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group date" id="timepicker-example2" data-target-input="nearest">
                                    <div class="input-group" data-target="#timepicker-example2" data-toggle="datetimepicker">
                                        <input type="text" name="end_time" class="form-control edit_time datetimepicker-input"  data-target="#timepicker-example2" autocomplete="off"/>
                                        <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                    </div>
                                </div>

                                <p class="text-danger">{{ $errors->first('end_time') }}</p>
                            </div>
                            <div class="col-md-12">
                            <p class="text-danger">Date & Time must be set Before {{date('d M, Y H:i:s A', strtotime($match_id->end_date))}}</p>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="">
                                <strong>Status</strong>
                            </label>
                            <select name="status" class="form-control input-lg edit_status" required="" selected="selected">
                                <option value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>
                            </select>
                            <br>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn  btn-gradient-success">Update </button>
                        <button type="button" class="btn btn-gradient-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
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


            $(document).ready(function () {
                $(document).on("click", '.edit_button', function (e) {
                    var name = $(this).data('name');
                    var end_time = $(this).data('datetime');
                    var enddate = $(this).data('enddate');
                    var status = $(this).data('status');
                    var id = $(this).data('id');
                    var act = $(this).data('act');


                    $(".edit_id").val(id);
                    $(".edit_question").val(name);
                    $(".edit_time").val(end_time);
                    $(".edit_date").val(enddate);
                    $(".edit_status").val(status).attr('selected', 'selected');

                });
            });


        })(jQuery);
    </script>
@stop
