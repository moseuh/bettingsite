@extends('user')

@section('css')
    <link rel="stylesheet" href="{{asset('public/templates/css/custom-table.css')}}">
@stop
@section('content')

    @include('partials.breadcrumb')

    <div class="faq-section shadow-bg">
        <div class="container">


            <div class="row">
                <div class="col-md-12">
                    <div class="table-custom">
                        <table class="table table-striped">
                            <thead >
                            <tr class="result-table-header">
                                <th scope="col">#@lang('SL')</th>
                                <th scope="col" class="w-50">@lang('Details')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Charge')</th>
                                <th scope="col">@lang('Remaining Balance')</th>
                                <th scope="col">@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $k=>$data)

                                <tr class="result-table-tr">
                                    <td data-label="#@lang('SL')">{{++$k}}</td>
                                    <td data-label="@lang('Details')">@php echo $data->title @endphp</td>
                                    <td data-label="@lang('Amount')">
                                      <span class="font-weight-bold @if($data->type == '+') text-success @elseif($data->type == '-')  text-danger @elseif($data->type == '*') text-primary @endif ">
                                          @if($data->type == '+')+@elseif($data->type == '-')-@elseif($data->type == '*')+@endif
                                          {{$data->amount}} {{__($basic->currency)}}</span>
                                    </td>
                                    <td data-label="@lang('Charge')"><span class="font-weight-bold ">{{$data->charge}} {{__($basic->currency)}}</span></td>
                                    <td data-label="@lang('Remaining Balance')"><span class="font-weight-bold ">{{$data->main_amo}} {{__($basic->currency) }}</span></td>


                                    <td data-label="@lang('Time')">
                                        {{date('d-m-y h:i A',strtotime($data->created_at))}}
                                    </td>
                                </tr>
                                @empty
                                    <tr class="result-table-tr">
                                        <td colspan="6">@lang('No Data Found!')</td>
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
