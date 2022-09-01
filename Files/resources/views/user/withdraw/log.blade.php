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
                                <th scope="col">@lang('Trx')</th>
                                <th scope="col">@lang('Payment Gateway')</th>
                                <th scope="col">@lang('Amount')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Time')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $k=>$data)
                                <tr class="result-table-tr">
                                    <td  data-label="@lang('SL')">{{++$k}}</td>
                                    <td  data-label="#@lang('Trx')">{{$data->transaction_id}}</td>
                                    <td  data-label="@lang('Payment Gateway')">{{$data->method->name}}</td>
                                    <td  data-label="@lang('Amount')">{{formatter_money($data->amount)}} {{__($basic->currency)}}</td>
                                    <td data-label="@lang('Status')">
                                        @if($data->status == 1)
                                            <label class="badge badge-warning"><i class="fa fa-spinner"></i> @lang('Pending') </label>
                                        @elseif($data->status == 2)
                                            <label class="badge badge-success"><i class="fa fa-check"></i> @lang('Success') </label>
                                        @elseif($data->status == -2)
                                            <label class="badge badge-danger"><i class="fa fa-close"></i> @lang('Rejected') </label>
                                        @endif
                                    </td>


                                    <td data-label="@lang('Time')">
                                        {{date('d M, Y h:i A',strtotime($data->created_at))}}
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
