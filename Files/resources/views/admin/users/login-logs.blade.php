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
                        Login Logs
                    </h4>


                          <table class="table ">
                              <thead>
                              <tr>
                                  <th scope="col">User</th>
                                  <th scope="col">IP</th>
                                  <th scope="col">Location</th>
                                  <th scope="col">Browser</th>
                                  <th scope="col">Operating System</th>
                                  <th scope="col">country</th>
                                  <th scope="col">Time</th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($logs as $log)
                                  <tr>
                                      <td data-label="Username"><a href="{{route('user.single',$log->user->id)}}">{{$log->user->name}}</a></td>
                                      <td data-label="User IP">{{$log->user_ip}}</td>
                                      <td data-label="User Location">{{$log->location}}</td>
                                      <td data-label="Browser">{{$log->browser}}</td>
                                      <td data-label="OS">{{$log->os}}</td>
                                      <td data-label="country">{{$log->country}}</td>
                                      <td data-label="Time">{{ $log->created_at->diffForHumans() }}</td>
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

