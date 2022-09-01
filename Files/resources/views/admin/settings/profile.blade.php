@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

          <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-account-circle "></i>
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
                              <form class="forms-sample" role="form" action="{{route('admin.profile')}}" method="post" enctype="multipart/form-data">
                              @csrf


                              
                                <div class="form-group row">
                                  <label for="name" class="col-sm-3 col-form-label">Profile Picture</label>
                                  <div class="col-sm-9">
                                  <div class="fileinput fileinput-new" data-provides="fileinput">
                                        @if($admin->image == null)
                                            <div class="fileinput-new thumbnail w-215 h-215"  data-trigger="fileinput">
                                                <img class="w-215" src="{{ asset('public/images/user/user-default.jpg') }}/" alt="...">
                                            </div>
                                        @else
                                            <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                <img class="w-215" src="{{ asset('public/images/user/') }}/{{$admin->image}}" alt="...">
                                            </div>
                                        @endif

                                        <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215"></div>
                                        <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                            <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                        </div>
                                    </div>

                                    @if ($errors->has('image'))
                                        <p class="text-danger">{{ $errors->first('image') }}</p>
                                    @endif

                                  </div>
                                </div>


                                <div class="form-group row">
                                  <label for="name" class="col-sm-3 col-form-label">Name</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="name" value="{{$admin->name}}"   class="form-control" id="name" placeholder="Your Name">
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="username" class="col-sm-3 col-form-label">Username</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="username" value="{{$admin->username}}" class="form-control" id="username" placeholder="username">
                                    @if ($errors->has('username'))
                                        <p class="text-danger">{{ $errors->first('username') }}</p>
                                    @endif
                                  </div>
                                </div>

                                
                                <div class="form-group row">
                                  <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="email" value="{{$admin->email}}" class="form-control" id="email" placeholder="E-mail Address">
                                    @if ($errors->has('email'))
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                  </div>
                                </div>
                                

                                <div class="form-group row">
                                  <label for="mobile" class="col-sm-3 col-form-label">Mobile Number</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="mobile" value="{{$admin->mobile}}" class="form-control" id="mobile" placeholder="Mobile number">
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


@section('import-js')
<script src="{{asset('public/admin/js/bootstrap-fileinput.js')}}"></script>
@stop
