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
                        Withdraw Log
                    </h4>


                          <table class="table ">
                              <thead>
                              <tr>
                                  <th scope="col">Username</th>
                                  <th scope="col">#TRX</th>
                                  <th scope="col">Gateway</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Date</th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($logs as $data)
                                  <tr>
                                      <td data-label="Username">
                                          <a href="{{route('user.single', $data->user->id)}}">
                                              {{$data->user->username}}
                                          </a>
                                      </td>

                                      <td data-label="#Trx">{{$data->transaction_id}}</td>
                                      <td data-label="Gateway">{{$data->method->name}}</td>
                                      <td data-label="Amount"><strong>{{number_format($data->amount, 2)}} {{$basic->currency}}</strong></td>
                                      <td data-label="Status">
                                          @if($data->status == 2)
                                              <span class="badge badge-gradient-success"> Completed </span>
                                          @elseif($data->status == -2)
                                              <span class="badge badge-gradient-danger"> Refunded </span>
                                          @elseif($data->status == 1)
                                              <span class="badge badge-gradient-warning"> Pending </span>

                                          @endif
                                      </td>

                                      <td data-label="Date">
                                          {{date('d M,Y h:i A',strtotime($data->updated_at))}}
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
