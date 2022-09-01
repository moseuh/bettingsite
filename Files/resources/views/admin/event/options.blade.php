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
              </span> {{$ques->match->name}}  </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">

                    <h4 class="card-title mb-5">
                         Question: {{$page_title}}
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic">
                                <a href="{{route('view.question',$ques->match->id)}}"
                                   class="btn btn-sm btn-gradient-danger  active ">
                                    <i class="mdi mdi-eye"></i> All Question
                                </a>

                                <a href="#0"
                                   data-toggle="modal" data-target="#AddOption"
                                   class="btn btn-sm btn-gradient-success   active ">
                                    <i class="mdi mdi-plus-circle"></i> Add Option
                                </a>
                            </div>
                        </div>
                    </h4>


                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Thread </th>
                            <th scope="col">Ratio</th>
                            <th scope="col">Total Predict Amount</th>
                            <th scope="col">Total Return Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($betoption as $k=>$data)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Thread">{{$data->option_name}}</td>
                                <td data-label="Ratio"><strong> {{$data->ratio1}} : {{$data->ratio2}}</strong></td>
                                @php
                                    $investTk = App\BetInvest::where('betoption_id',$data->id)->where('status','!=',2)->sum('invest_amount');
                                    $giveBackTk = App\BetInvest::where('betoption_id',$data->id)->where('status','!=',2)->sum('return_amount');
                                @endphp
                                <td data-label="Total Predict  Amount"><strong>{{number_format($investTk,2)}} {{$basic->currency}} </strong></td>
                                <td data-label="Total Return Amount"><strong>{{number_format($giveBackTk,2)}} {{$basic->currency}} </strong></td>

                                <td data-label="Status">
                                    <label class="badge  badge-gradient-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</label>
                                </td>
                                <td data-label="Action">
                                    <button type="button"
                                            class="btn btn-gradient-info btn-sm btn-rounded btn-icon  tooltip-styled edit_button"
                                            data-tooltip-content="Edit"

                                            data-toggle="modal" data-target="#myModal"
                                            data-act="Edit"
                                            data-name="{{$data->option_name}}"
                                            data-invest="{{$data->invest_amount}}"
                                            data-minamo="{{$data->min_amo}}"
                                            data-retrunamo="{{$data->return_amount}}"
                                            data-ratio1="{{$data->ratio1}}"
                                            data-ratio2="{{$data->ratio2}}"
                                            data-bet="{{$data->bet_ratio}}"
                                            data-status="{{$data->status}}"
                                            data-bet_limit="{{$data->bet_limit}}"
                                            data-id="{{$data->id}}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="card-footer">
                    {{$betoption->links()}}
                </div>
            </div>
        </div>


    </div>



    <!-- Modal for Add button -->
    <div class="modal fade" id="AddOption" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Add Option </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{route('createNewOption')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><strong>Option Name</strong></label>

                        <input class="" type="hidden" value="{{$ques->id}}" name="ques_id">
                        <input class="" type="hidden" value=" {{$ques->match->id}}" name="match_id">
                        <input class="form-control input-lg " type="text" name="option_name"  required>
                    </div>

                    <div class="form-group">
                        <label for=""><strong>Minimum Predict Amount</strong></label>
                        <input class="form-control input-lg " name="min_amo" value="100" step="any" type="number" required>
                    </div>
                    <div class="form-group">
                        <label><strong> Prediction Limit Amount</strong></label>
                        <input class="form-control input-lg " name="bet_limit" step="any" value="2000" type="number" required>
                    </div>


                    <div class="form-group">
                        <label for=""><strong>Ratio</strong></label>
                        <br>
                        <input type="number"   class="form-control ratio-left" step="0.01" name="ratio1"  required>
                        <span class="ratio-center" >:</span>

                        <input  type="number" class="form-control ratio-right " step="0.01" name="ratio2"  required>
                    </div>

                    <div class="form-group">
                        <br><br>
                        <label for=""><strong>Status</strong></label>
                        <select name="status" class="form-control input-lg" required>
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
        </div>
    </div>



    <!-- Modal for Edit button -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><b class="abir_act"></b> Option </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="post" action="{{route('update.option')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><strong>Option Name</strong></label>
                        <input class="form-control ronnie_id" type="hidden" name="id">
                        <input class="form-control input-lg ronnie_question" type="text" name="option_name"  required>
                    </div>

                    <div class="form-group">
                        <label><strong>Minimum Prediction Amount</strong></label>
                        <input class="form-control input-lg ronnie_minamo" name="min_amo" step="any" type="number" required>
                    </div>


                    <div class="form-group">
                        <label><strong>Prediction Limit Amount</strong></label>
                        <input class="form-control input-lg ronnie_bet_limit" name="bet_limit" step="any" type="number" required>
                    </div>

                    <div class="form-group">
                        <label><strong>Ratio</strong></label>
                        <br>
                        <input type="number"   class="form-control ratio-left   ronnie_ratio1" step="0.01" name="ratio1"  required>
                        <span class="ratio-center">:</span>

                        <input type="number" class="form-control ratio-right  ronnie_ratio2 " step="0.01" name="ratio2"  required>
                    </div>

                    <div class="form-group">
                        <br><br>
                        <label for="status"><strong>Status</strong></label>
                        <select name="status" class="form-control input-lg ronnie_status" required>
                            <option value="1">Active</option>
                            <option value="0">DeActive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        </div>
    </div>

@endsection



@section('import-js')

@stop
@section('script')
    <script>
        (function ($) {
            "use strict";


            $(document).on("click", '.edit_button', function (e) {

                var name = $(this).data('name');
                var invest_amount = $(this).data('invest');
                var return_amount = $(this).data('retrunamo');
                var ratio1 = $(this).data('ratio1');
                var ratio2 = $(this).data('ratio2');
                var bet_ratio = $(this).data('bet');
                var status = $(this).data('status');
                var minamo = $(this).data('minamo');
                var bet_limit = $(this).data('bet_limit');
                var id = $(this).data('id');
                var act = $(this).data('act');

                $(".ronnie_id").val(id);
                $(".ronnie_question").val(name);
                $(".ronnie_invest_amount").val(invest_amount);
                $(".ronnie_return_amount").val(return_amount);
                $(".ronnie_ratio1").val(ratio1);
                $(".ronnie_ratio2").val(ratio2);

                $(".ronnie_ratio").val(bet_ratio);
                $(".ronnie_minamo").val(minamo);
                $(".ronnie_bet_limit").val(bet_limit);
                $(".ronnie_status").val(status).attr('selected', 'selected');
                $(".abir_act").text(act);

            });


            $(document).on('keypress keyup', '.invest_amount,.return_amount', function () {
                var tr = $(this).parent().parent();
                var investAmount = parseInt(tr.find('.invest_amount').val());
                var returnAmount = parseInt(tr.find('.return_amount').val());
                var ratio = returnAmount / investAmount;
                if (ratio > 0) {
                    tr.find('.bet_ratio').val('1:' + ratio);
                }
            });

        })(jQuery);
    </script>
@stop
