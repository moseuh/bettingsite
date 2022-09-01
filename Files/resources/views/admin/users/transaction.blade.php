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
                        Transaction
                    </h4>


                          <table class="table ">
                              <thead>
                              <tr>
                                  <th scope="col">SL</th>
                                  <th scope="col">Details</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Remaining Balance</th>
                                  <th scope="col">Time</th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($logs as $k=>$data)
                                  <tr>
                                      <td data-label="SL">
                                          {{++$k}}
                                      </td>
                                      <td data-label="Details"><p>@php echo $data->title @endphp</p></td>
                                      <td data-label="Amount">

                                          @if($data->type == '+') <strong class="text-success"> +  {{$data->amount}} {{$basic->currency}}</strong>
                                          @elseif($data->type == '-') <strong class="text-danger"> -  {{$data->amount}} {{$basic->currency}}</strong>
                                          @elseif($data->type == '*') <strong class="text-info"> -  {{$data->amount}} {{$basic->currency}}</strong>
                                          @endif
                                      </td>
                                      <td data-label="Remaining Balance">

                                             <strong>{{$data->main_amo}} {{$basic->currency}}</strong></td>
                                      <td data-label="Time">{{date('d M, Y h:i A',strtotime($data->created_at))}} </td>
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
