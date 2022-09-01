@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-account-multiple-outline"></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">

        @include('admin.users.user-sidebar')

        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">
                    <h4 class="card-title mb-5">
                        Prediction Log
                    </h4>


                    <div class="table">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col">@lang('SL')</th>
                                <th scope="col">@lang('Event')</th>
                                <th scope="col">@lang('Question')</th>
                                <th scope="col">@lang('Threat')</th>
                                <th scope="col"> @lang('Predict Amount')</th>
                                <th scope="col"> @lang('Return Amount')</th>
                                <th scope="col"> @lang('Available Balance')</th>
                                <th scope="col"> @lang('Ratio')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Predict Time')</th>
                                <th scope="col">@lang('Result Time')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($logs as $k=>$data)
                                <tr class="result-table-tr">
                                    <td data-label="@lang('SL')">{{++$k}}</td>
                                    <td data-label="@lang('Match')">{{$data->match->name}}</td>
                                    <td data-label="@lang('Question')">{{$data->ques->question }}</td>
                                    <td data-label="@lang('Threat')">{{$data->betoption->option_name }} </td>
                                    <td data-label="@lang('Predict Amount')">{{$data->invest_amount}} {{__($basic->currency)}}</td>
                                    <td data-label="@lang('Return Amount')">{{$data->return_amount}} {{ __($basic->currency)}}
                                        <br>
                                        @if($data->status  == 1)  <span class="badge badge-danger">(@lang('Charge')
                                            : {{$data->charge}}  {{__($basic->currency)}})  </span> @endif</td>
                                    <td data-label="@lang('Available Balance')">
                                        @if($data->remaining_balance != null)
                                            {{round($data->remaining_balance,2)}} {{__($basic->currency)}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td data-label="@lang('Ratio')">{{$data->ratio}}</td>

                                    <td data-label="@lang('Status')">

                                        @if($data->status  == 1)
                                            <label class="badge badge-gradient-success">@lang('Win')</label>
                                        @elseif($data->status  == -1)
                                            <label class="badge badge-gradient-danger">@lang('Lose')</label>
                                        @elseif($data->status  == 2)
                                            <label class="badge badge-gradient-primary">@lang('Refunded')</label>
                                        @else
                                            <label class="badge badge-gradient-warning">@lang('Processing')</label>
                                        @endif
                                    </td>

                                    <td data-label="@lang('Predict Time')">
                                        {{date('h:i A',strtotime($data->created_at))}}
                                    </td>

                                    <td data-label="@lang('Result Time')">
                                        @if($data->status  == 0)
                                            <label class="badge badge-gradient-warning">@lang('Processing')</label>
                                        @else
                                            {{date('d M Y h:i A',strtotime($data->updated_at))}}
                                        @endif

                                    </td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>


                </div>
                <div class="card-footer">
                    {{$logs->links()}}
                </div>
            </div>
        </div>


    </div>







@endsection


@section('script')


@stop
