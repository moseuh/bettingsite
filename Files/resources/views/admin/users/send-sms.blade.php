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
                        Send Mail
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <form class="forms-sample" role="form" action="{{route('send.sms')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">Sent To</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" class="form-control " value="{{$user->phone}}" readonly >
                                        @if ($errors->has('phone'))
                                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="username" class="form-control" value="{{$user->username}}"  readonly>
                                        @if ($errors->has('username'))
                                            <p class="text-danger">{{ $errors->first('username') }}</p>
                                        @endif
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <label for="message" class="col-sm-3 col-form-label">Write Message </label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" name="message" rows="10" placeholder="Write Message">{{old('message')}}</textarea>
                                        @if ($errors->has('message'))
                                            <p class="text-danger">{{ $errors->first('message') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('import-js')
@stop

@section('script')


@stop
