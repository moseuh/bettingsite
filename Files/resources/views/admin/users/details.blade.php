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
                        Profile Settings
                    </h4>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form class="forms-sample" role="form" action="{{route('user.status',[$user->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')


                                <div class="form-group row">
                                    <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" value="{{$user->first_name}}"   class="form-control" id="first_name" placeholder="First Name">
                                        @if ($errors->has('first_name'))
                                            <p class="text-danger">{{ $errors->first('first_name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" value="{{$user->last_name}}"   class="form-control" id="last_name" placeholder="Last Name">
                                        @if ($errors->has('last_name'))
                                            <p class="text-danger">{{ $errors->first('last_name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="username" value="{{$user->username}}"   class="form-control" id="username" placeholder="Username">
                                        @if ($errors->has('username'))
                                            <p class="text-danger">{{ $errors->first('username') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" value="{{$user->email}}"   class="form-control" id="email" placeholder="Email Address">
                                        @if ($errors->has('email'))
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                </div>







                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" value="{{$user->phone}}" class="form-control" id="mobile" placeholder="Mobile number">
                                        @if ($errors->has('phone'))
                                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" value="{{$user->address}}" class="form-control" id="address" placeholder="Address">
                                        @if ($errors->has('address'))
                                            <p class="text-danger">{{ $errors->first('address') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="city" class="col-sm-3 col-form-label">City</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="city" value="{{$user->city}}" class="form-control" id="city" placeholder="City">
                                        @if ($errors->has('city'))
                                            <p class="text-danger">{{ $errors->first('city') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip_code" class="col-sm-3 col-form-label">Zip</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="zip_code" value="{{$user->zip_code}}" class="form-control" id="zip_code" placeholder="Zip code">
                                        @if ($errors->has('zip_code'))
                                            <p class="text-danger">{{ $errors->first('zip_code') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip_code" class="col-sm-3 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="country" value="{{$user->country}}" class="form-control" id="country" placeholder="Country">
                                        @if ($errors->has('country'))
                                            <p class="text-danger">{{ $errors->first('country') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Phone verification</label>
                                    <div class="col-sm-9">

                                        <select name="phone_verify" id="phone_verify" class="form-control">
                                            <option value="1" @if($user->phone_verify  == 1) selected @endif>Yes</option>
                                            <option value="0" @if($user->phone_verify  == 0) selected @endif>No</option>
                                        </select>
                                        @if ($errors->has('phone_verify'))
                                            <p class="text-danger">{{ $errors->first('phone_verify') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Email verification</label>
                                    <div class="col-sm-9">
                                        <select name="email_verify" id="email_verify" class="form-control">
                                            <option value="1" @if($user->email_verify  == 1) selected @endif>Yes</option>
                                            <option value="0" @if($user->email_verify  == 0) selected @endif>No</option>
                                        </select>
                                        @if ($errors->has('email_verify'))
                                            <p class="text-danger">{{ $errors->first('email_verify') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">

                                        <select name="status" id="status" class="form-control">
                                            <option value="1" @if($user->status  == 1) selected @endif>Active</option>
                                            <option value="0" @if($user->status  == 0) selected @endif>Blocked</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <p class="text-danger">{{ $errors->first('status') }}</p>
                                        @endif
                                    </div>
                                </div>










                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Update Profile</button>
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


