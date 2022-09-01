@extends('user')

@section('css')
    <link rel="stylesheet" href="{{asset('public/templates/css/custom-table.css')}}">
@stop
@section('content')

    @include('partials.breadcrumb')

    <div class="faq-section shadow-bg ">
        <div class="container">


            <div class="row py-2">
                <div class="col-md-12">
                    <div class="table-custom">
                        <table class="table table-striped">
                            <thead >
                            <tr class="result-table-header">
                                <th scope="col">#@lang('SL')</th>
                                <th scope="col">@lang('Event')</th>
                                <th scope="col">@lang('Question')</th>
                                <th scope="col">@lang('Threat')</th>
                                <th scope="col">@lang('Predict Amount')</th>
                                <th scope="col">@lang('Return Amount')</th>
                                <th scope="col">@lang('Result')</th>
                                <th scope="col">@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $k=>$data)
                                <tr class="result-table-tr">
                                    <td scope="row">{{++$k}}</td>
                                    <td data-label="@lang('Event')">{{($data->match) ? str_limit($data->match->name,30) : '-' }}</td>
                                    <td data-label="@lang('Question')">{{($data->ques) ? $data->ques->question : '-'}}</td>
                                    <td data-label="@lang('Threat')">{{($data->betoption) ? $data->betoption->option_name : ''}} </td>
                                    <td data-label="@lang('Predict Amount')" class=" font-weight-bold">{{$data->invest_amount}} {{__($basic->currency)}}</td>
                                    <td data-label="@lang('Return Amount')" class=" font-weight-bold">{{$data-> return_amount}} {{ __($basic->currency) }} <br>
                                        @if($data->status  == 1)  <span class="badge badge-danger my-1">(@lang('Charge'): {{$data->charge}}  {!! __($basic->currency) !!})  </span> @endif
                                    </td>

                                    <td data-label="@lang('Result')">
                                        @if($data->status  == 1)
                                            <label class="badge badge-success">@lang('Win')</label>
                                        @elseif($data->status  == -1)
                                            <label class="badge badge-danger">@lang('Lose')</label>
                                        @elseif($data->status  == 2)
                                            <label class="badge badge-primary">@lang('Refunded')</label>
                                        @else
                                            <label class="badge badge-warning">@lang('Processing')</label>
                                        @endif
                                    </td>


                                    <td data-label="@lang('Time')">
                                        {{date('d M, Y h:i A',strtotime($data->created_at))}}
                                    </td>
                                </tr>

                            @empty
                                <tr class="result-table-tr">
                                    <td colspan="8">@lang('No Data Found!')</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>

                    </div>

                    <div class="pagination-nav ">
                        {{$logs->links()}}
                    </div>

                </div>
            </div>

        </div>
    </div>
@stop
