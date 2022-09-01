@extends('admin.layout.master')

@section('content')

          <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-account-key "></i>
              </span> {{$page_title}} </h3>

              

          </div>

            <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  
                  <div class="card-body">
                  <h4 class="card-title mb-5"> 
                  <div class="float-right">
                    @include('admin.settings.nav')
                  </div>
                  </h4>

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                              <form class="forms-sample" action="" method="post">
                              @csrf
                                <div class="form-group row">
                                  <label for="CurrentPassword" class="col-sm-3 col-form-label">Current Password</label>
                                  <div class="col-sm-9">
                                    <input type="password" name="old_password" class="form-control" id="CurrentPassword" placeholder="Current Password">

                                    @if ($errors->has('old_password'))
                                        <p class="text-danger">{{ $errors->first('old_password') }}</p>
                                    @endif
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                  <div class="col-sm-9">
                                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                                    @if ($errors->has('new_password'))
                                        <p class="text-danger">{{ $errors->first('new_password') }}</p>
                                    @endif
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                                  <div class="col-sm-9">
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password">
                                    @if ($errors->has('password_confirmation'))
                                        <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                                    @endif
                                  </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                      <button type="submit" class="btn btn-gradient-success btn-block">Submit</button>
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


@section('script')
@stop