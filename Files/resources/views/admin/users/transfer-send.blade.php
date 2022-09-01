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
                        Money Transfer ( Send )

                    </h4>


                          <table class="table ">
                              <thead>
                              <tr>
                                  <th scope="col">@lang('SL')</th>
                                  <th scope="col">@lang('Username')</th>
                                  <th scope="col"> @lang('Amount')</th>
                                  <th scope="col"> @lang('Charge')</th>
                                  <th scope="col">@lang('Time')</th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($logs as $k=>$data)
                                  <tr class="result-table-tr">
                                      <td data-label="@lang('SL')">{{++$k}}</td>
                                      <td data-label="@lang('Username')">
                                          <a href="{{route('user.single',$data->transferTo->id)}}">
                                              {{$data->transferTo->username}}
                                          </a>
                                      </td>
                                      <td data-label="@lang('Amount')">{{number_format($data->amount,2)}} {{$basic->currency}}</td>
                                      <td data-label="@lang('Charge')">{{number_format($data->charge,2)}} {{$basic->currency}}</td>
                                      <td data-label="@lang('Time')">{{date('d M Y h:i A',strtotime($data->created_at))}}</td>
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
