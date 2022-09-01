@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-trophy-outline"></i>
              </span> {{$ques->match->name}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">

                    <h4 class="card-title mb-5">
                        {{$page_title}}
                    </h4>
                    @include('errors.error')
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Thread</th>
                            <th scope="col">Ratio</th>
                            <th scope="col">Total Predict Amount</th>
                            <th scope="col">Total Return Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($betoption) > 0)
                            @foreach($betoption as $k=>$data)
                                <tr>
                                    <td data-label="SL">{{++$k}}</td>
                                    <td data-label="Thread">{!! $data->option_name !!}</td>
                                    <td data-label="Ratio"><strong>{!! $data->ratio1	 !!} : {!! $data->ratio2 !!}</strong></td>


                                    <td data-label="Total Predict Amount">
                                        <a href="{{route('bet-option-userlist',$data->id)}}"
                                           class=" tooltip-styled" data-tooltip-content="Predictor List">
                                            <strong class="text-success">{{number_format($data->investTk(),2)}} {{$basic->currency}} </strong>
                                        </a>
                                    </td>

                                    <td data-label="Total Return Amount"><strong class="text-danger">{{number_format($data->giveBackTk(),2)}} {{$basic->currency}} </strong></td>
                                    <td data-label="Status">
                                        @if($data->status ==1)
                                            <label class="badge badge-gradient-warning">Pending</label>
                                        @elseif($data->status ==2)
                                            <label class="badge badge-gradient-success">win</label>
                                        @elseif($data->status ==0)
                                            <label class="badge badge-gradient-info">DeActive</label>
                                        @elseif($data->status ==-2)
                                            <label class="badge badge-gradient-danger">Lost</label>

                                        @elseif($data->status ==3)
                                            <label class="badge badge-gradient-success">Refunded</label>
                                        @endif
                                    </td>
                                    <td data-label="ACTION">
                                        @if(($data->status == 0) or ($data->status == 1))
                                            @if(in_array('21',$access))
                                                <button type="button"
                                                        class="edit_button btn btn-gradient-info btn-sm btn-rounded btn-icon  tooltip-styled"
                                                        data-tooltip-content="Make Winner"

                                                        data-toggle="modal" data-target="#myModal"
                                                        data-act=""
                                                        data-id="{{$data->id}}"
                                                        data-ques_id="{{$ques->id}}"
                                                        data-matchid="{{$data->match->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            @endif
                                        @elseif($data->status ==2 || $data->status == -2 || $data->status == 3)

                                            <label class="badge badge-gradient-info">Completed</label>
                                        @endif

                                    </td>


                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="7"><strong>No Data Found!!</strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>





                </div>
                <div class="card-footer">
                    {{$betoption->links()}}
                </div>
            </div>
        </div>


    </div>







    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Make Winner </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('make.winner')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <strong>Are you sure want to Make winner this ??</strong>
                        <div class="form-group">
                            <input type="hidden" name="betoption_id" class="ronnie_id" >
                            <input type="hidden" name="match_id" class="ronnie_match_id" >

                            <input type="hidden" name="ques_id" class="ronnie_ques_id" >
                        </div>
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


            $(document).ready(function () {
                $(document).on("click", '.edit_button', function (e) {
                    var ques_id = $(this).data('ques_id');
                    var match_id = $(this).data('matchid');
                    var id = $(this).data('id');
                    var act = $(this).data('act');
                    $(".ronnie_id").val(id);
                    $(".ronnie_match_id").val(match_id);
                    $(".ronnie_ques_id").val(ques_id);
                    $(".abir_act").text(act);
                });
            });

        })(jQuery);

    </script>
@stop
