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
                      {{$page_title}}

                      <div class="float-right">
                          <div class="btn-group" role="group" aria-label="Basic">
                              <a href="{{route('testimonial.create')}}"
                                 class="btn btn-sm btn-outline-success   active ">
                                  <i class="mdi mdi-plus-circle"></i> Add New
                              </a>
                          </div>
                      </div>
                  </h4>

                        <div class="row justify-content-center">
                            <div class="col-md-10">
                              <form class="forms-sample" role="form" action="" method="post" enctype="multipart/form-data">
                              @csrf



                                  <div class="form-group row">
                                      <label for="name" class="col-sm-3 col-form-label"> Image</label>
                                      <div class="col-sm-9">
                                          <div class="fileinput fileinput-new" data-provides="fileinput">
                                              <div class="fileinput-new thumbnail w-215 h-215"  data-trigger="fileinput">
                                                  <img class="w-215" src="{{ asset('public/images/user/default.jpg') }}/" alt="...">
                                              </div>


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
                                  <label for="title" class="col-sm-3 col-form-label">Name</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="name" value="{{old('name')}}"   class="form-control" id="name" placeholder="Name">
                                    @if ($errors->has('name'))
                                        <p class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <label for="designation" class="col-sm-3 col-form-label">Designation</label>
                                  <div class="col-sm-9">
                                    <input type="text" name="designation" value="{{old('designation')}}"   class="form-control" id="designation" placeholder="Designation">
                                    @if ($errors->has('designation'))
                                        <p class="text-danger">{{ $errors->first('designation') }}</p>
                                    @endif
                                  </div>
                                </div>




                                <div class="form-group row">
                                  <label for="details" class="col-sm-3 col-form-label">Details</label>
                                  <div class="col-sm-9">
                                      <textarea name="details" class="form-control" id="details"  rows="10">{{old('details')}}</textarea>
                                    @if ($errors->has('details'))
                                        <p class="text-danger">{{ $errors->first('details') }}</p>
                                    @endif
                                  </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                      <button type="submit" class="btn btn-gradient-success btn-block">Save </button>
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

