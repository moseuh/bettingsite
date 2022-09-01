@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-trophy-outline"></i>
              </span> {{$betQuestion->match->name}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">

                    <h4 class="card-title mb-5">
                        {{$betQuestion->question}}
                    </h4>
                    @include('errors.error')
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Username</th>
                            <th scope="col">Threat</th>
                            <th scope="col">Predict Amount</th>
                            <th scope="col">Return Amount</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($betInvest) > 0)
                            @foreach($betInvest as $k=>$data)
                                <tr>
                                    <td data-label="SL">{{++$k}}</td>

                                    <td data-label="Username">
                                        <a href="{{route('user.single',$data->user_id)}}">
                                            <strong>{{$data->user->username}} </strong>
                                        </a>
                                    </td>
                                    <td data-label="Threat">
                                        <strong>{{$data->betoption->option_name}} </strong>
                                    </td>
                                    <td data-label="Bet Amount"><strong
                                                class="text-success">{{number_format($data->invest_amount, $basic->decimal)}} {{$basic->currency}} </strong>
                                    </td>
                                    <td data-label="Return Amount"><strong
                                                class="text-danger">{{number_format($data->return_amount, $basic->decimal)}} {{$basic->currency}} </strong>
                                    </td>

                                    <td data-label="Time">
                                        {{date('d M Y h:i A',strtotime($data->created_at))}}
                                    </td>

                                    <td data-label="Status">
                                        @if($data->status ==-1)
                                            <label class="badge badge-gradient-danger">Lose</label>
                                        @elseif($data->status ==1)
                                            <label class="badge badge-gradient-success">win</label>
                                        @elseif($data->status ==0)
                                            @if(in_array('24',$access))
                                                <button type="button"

                                                        class="btn btn-gradient-primary btn-sm btn-rounded btn-icon refund_bet tooltip-styled"
                                                        data-tooltip-content="Refund Prediction Amount"

                                                        data-toggle="modal" data-target="#refundMyModal"
                                                        data-act="Refund "
                                                        data-id="{{$data->id}}">
                                                    <i class="fa fa-send"></i>
                                                </button>
                                            @endif
                                        @elseif($data->status ==2)
                                            <label class="badge badge-gradient-info">Refunded</label>
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
                    {{$betInvest->links()}}
                </div>
            </div>
        </div>


    </div>






    <!-- Modal for Refund button -->
    <div class="modal fade" id="refundMyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> Refund Amount Confirmation </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form method="post" action="{{route('refundBetInvestSingleUser')}}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are You want sure refund Amount ?</p>
                    </div>

                    <input class="form-control r_id" type="hidden" name="id">
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
                $(document).on("click", '.refund_bet', function (e) {
                    var id = $(this).data('id');
                    var act = $(this).data('act');
                    $(".r_id").val(id);

                });

            });

        })(jQuery);
    </script>
@stop
