@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-account-multiple-outline"></i>
              </span>  {{$page_title}} </h3>


    </div>

    <div class="row">

        @include('admin.users.user-sidebar')

        <div class="col-md-9 grid-margin stretch-card">
            <div class="card">



                <div class="card-body">
                    <h4 class="card-title mb-5">
                        Payment Log
                    </h4>


                          <table class="table ">
                              <thead>
                              <tr>
                                  <th scope="col">@lang('Username')</th>
                                  <th scope="col">#@lang('TRX')</th>
                                  <th scope="col">@lang('Gateway')</th>
                                  <th scope="col">@lang('Amount')</th>
                                  <th scope="col">@lang('Status')</th>
                                  <th scope="col">@lang('Date')</th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($logs as $k=>$data)
                                  <tr>
                                      <td data-label="@lang('Username')">
                                          <a href="{{route('user.single', $data->user->id)}}">
                                              {{$data->user->username}}
                                          </a>
                                      </td>

                                      <td data-label="#@lang('TRX')">{{$data->trx}}</td>
                                      <td data-label="@lang('Gateway')">{{$data->gateway_currency()->name}}</td>
                                      <td data-label="@lang('Amount')"><strong>{{number_format($data->amount,2)}} {{$basic->currency}}</strong></td>
                                      <td data-label="@lang('Status')">
                                          @if($data->status == 2)
                                              <span class="badge badge-gradient-success"> @lang('Completed') </span>
                                          @elseif($data->status == -2)
                                              <span class="badge badge-gradient-danger"> @lang('Rejected') </span>
                                          @elseif($data->status == 1)
                                              <span class="badge badge-gradient-warning"> @lang('Pending') </span>
                                          @endif
                                      </td>
                                      <td data-label="@lang('Date')">
                                          {{date('d M Y, h:i A',strtotime($data->updated_at))}}
                                      </td>
                                  </tr>
                              @endforeach


                              </tbody>
                          </table>







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
