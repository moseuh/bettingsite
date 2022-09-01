@extends('admin.layout.master')
@section('import-css')
@stop
@section('css')

@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-trophy-outline"></i>
              </span> {{$page_title}} </h3>
    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">


                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Question</th>
                            <th scope="col">Event</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Predictors</th>
                            <th scope="col" class="w-25p">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $k=>$data)
                            <tr @if($data->result == 1) class="danger" @endif>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Question">
                                    <strong>{{$data->question}}</strong>
                                </td>
                                <td data-label="Event">{{$data->match->name}}</td>
                                <td  data-label="End Time">{{(date('d M Y h:i A',strtotime($data->end_time)))}}</td>

                                <td data-label="Predictors">

                                        <a href="{{route('awaiting.winner.userlist',$data->id)}}"
                                           class="btn btn-gradient-primary btn-sm btn-rounded btn-icon text-decoration-none pt-12 tooltip-styled"

                                           data-tooltip-content="See All Predictors">
                                            {{$data->totalInvestor()}}
                                        </a>



                                </td>
                                <td data-label="Action">

                                    @if($data->result == 1)
                                        <a href="{{route('view.option.endtime',$data->id)}}"
                                           class="btn btn-gradient-success btn-sm btn-rounded btn-icon pt-12 tooltip-styled"
                                           data-tooltip-content="View Winner">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                    @else



                                        @if(in_array('21',$access))
                                            <a href="{{route('view.option.endtime',$data->id)}}"
                                               class="btn btn-gradient-dark btn-sm btn-rounded btn-icon pt-12 tooltip-styled"
                                               data-tooltip-content="Select Winner">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif
                                        @if(in_array('22',$access))
                                            <button type="button"

                                                    class="edit_ques btn btn-gradient-info btn-sm btn-rounded btn-icon  tooltip-styled"
                                                    data-tooltip-content="Update Question"
                                                    data-toggle="modal" data-target="#EditMyModal"
                                                    data-act="Edit"
                                                    data-matchenddate="{{date('d M, Y h:i:s A',strtotime($data->match->end_date))}}"
                                                    data-name="{{$data->question}}"
                                                    data-datetime="{{date('h:i A',strtotime($data->end_time))}}"
                                                    data-enddate="{{date('m/d/Y',strtotime($data->end_time))}}"
                                                    data-status="{{$data->status}}"
                                                    data-id="{{$data->id}}"
                                                    data-mid="{{$data->match_id}}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endif
                                        @if(in_array('23',$access))
                                            <button type="button"
                                                    class="refund_bet btn btn-gradient-danger btn-sm btn-rounded btn-icon  tooltip-styled"
                                                    data-tooltip-content="Refund Prediction Amount"

                                                    data-toggle="modal" data-target="#refundMyModal"
                                                    data-id="{{$data->id}}"
                                                    data-mid="{{$data->match_id}}">
                                                <i class="fa fa-send"></i>
                                            </button>
                                        @endif
                                    @endif

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






    <!-- Modal for Edit button -->
    <div class="modal fade" id="EditMyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><b class="modal_act"></b> Questions </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('update.question')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>
                                <strong>Question</strong>
                            </label>
                            <input class="form-control edit_id" type="hidden" name="id">
                            <input class="form-control input-lg edit_question" name="question" type="text" required>
                            <br>
                            <input class="form-control input-lg edit_match_id" name="match_id"  type="hidden" >
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label><strong>End Date</strong></label>
                            </div>

                            <div class="col-sm-7">

                                <div id="datepicker-popup" class="input-group date datepicker">
                                    <input type="text" name="end_date" class="edit_date form-control" autocomplete="off">
                                    <span class="input-group-addon input-group-append border-left">
                                                <span class="mdi mdi-calendar input-group-text"></span>
                                              </span>
                                </div>
                                <p class="text-danger">{{ $errors->first('end_date') }}</p>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group date" id="timepicker-example" data-target-input="nearest">
                                    <div class="input-group" data-target="#timepicker-example" data-toggle="datetimepicker">
                                        <input type="text" name="end_time" class="edit_time form-control datetimepicker-input"  data-target="#timepicker-example" autocomplete="off"/>
                                        <div class="input-group-addon input-group-append"><i class="mdi mdi-clock input-group-text"></i></div>
                                    </div>
                                </div>

                                <p class="text-danger">{{ $errors->first('end_time') }}</p>
                            </div>
                            <div class="col-md-12">
                                <p class="text-danger">This Date & Time will working  Before <span class="match_end_date"></span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">
                                <strong>Status</strong>
                            </label>
                            <select name="status" class="form-control input-lg edit_status" required>
                                <option value="">Status</option>
                                <option value="1">Active</option>
                                <option value="0">DeActive</option>
                            </select>
                            <br>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-gradient-success">Update</button>
                        <button type="button" class="btn btn-gradient-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal for Refund button -->
    <div class="modal fade" id="refundMyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><b class="modal_act"></b> Refund Prediction Amount </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('refundBetInvest')}}">
                    @csrf
                    <div class="modal-body">
                            <p>Are You want sure refund Amount?</p>

                        <input class="form-control r_id" type="hidden" name="question_id">
                        <input class="form-control input-lg r_match_id" name="match_id"  type="hidden" >
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
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
                $(document).on("click", '.edit_ques', function (e) {
                    var name = $(this).data('name');
                    var end_time = $(this).data('datetime');
                    var enddate = $(this).data('enddate');

                    var status = $(this).data('status');
                    var id = $(this).data('id');
                    var mid = $(this).data('mid');
                    var act = $(this).data('act');
                    var match_end_date = $(this).data('matchenddate');

                    $(".edit_id").val(id);
                    $(".edit_question").val(name);
                    $(".edit_time").val(end_time);
                    $(".edit_date").val(enddate);
                    $(".edit_match_id").val(mid);
                    $(".match_end_date").text(match_end_date);
                    $(".edit_status").val(status).attr('selected', 'selected');
                    $(".modal_act").text(act);

                });

                $(document).on("click", '.refund_bet', function (e) {
                    var id = $(this).data('id');
                    var mid = $(this).data('mid');
                    var act = $(this).data('act');

                    $(".r_id").val(id);
                    $(".r_match_id").val(mid);
                    $(".modal_act").text(act);

                });
            });

        })(jQuery);


    </script>
@stop
