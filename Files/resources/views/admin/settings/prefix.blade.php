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
                                  <label for="prefix" class="col-sm-3 col-form-label">Admin Prefix</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="prefix" value="{{$basic->prefix}}" class="form-control" id="prefix" placeholder="Admin Prefix">

                                    @if ($errors->has('prefix'))
                                        <p class="text-danger">{{ $errors->first('prefix') }}</p>
                                    @endif
                                  </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                      <button type="submit" class="btn btn-gradient-success btn-block">Update</button>
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