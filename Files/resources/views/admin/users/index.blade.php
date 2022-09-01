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

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">

                    <h4 class="card-title mb-5">
                       <div class="row justify-content-end">
                           <div class="col-4">
                               <form action="{{route('search.users')}}" method="get">
                                   <div class="form-group">
                                       <div class="input-group">
                                           <input type="text" class="form-control" name="search" value="{{@$search}}" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                           <div class="input-group-append">
                                               <button class="btn btn-sm btn-gradient-success" type="submit">Search</button>
                                           </div>
                                       </div>
                                   </div>
                               </form>
                           </div>
                       </div>
                    </h4>



                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td data-label="Name">{{$user->name}}</td>
                                <td data-label="Username"> <strong>{{$user->username}} </strong></td>
                                <td data-label="Mobile">{{$user->phone}}</td>
                                <td data-label="Balance">{{$user->balance}} {{$basic->currency}}</td>
                                <td data-label="Status">
                                    @if($user->status == 1)
                                    <label class="badge badge-gradient-success">Active</label>
                                    @else
                                    <label class="badge badge-gradient-danger">Blocked</label>
                                    @endif
                                </td>
                                <td  data-label="Details">
                                    <a href="{{route('user.single', $user->id)}}"

                                       data-tooltip-content="User Details"
                                       class="btn btn-gradient-success btn-sm btn-rounded btn-icon pt-12 tooltip-styled">


                                        <i class="fa fa-eye"></i>
                                    </a>


                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>





                </div>
                <div class="card-footer">
                    {{$users->appends(['search'=>@$search])->links()}}
                </div>
            </div>
        </div>


    </div>




@endsection


@section('script')


@stop
