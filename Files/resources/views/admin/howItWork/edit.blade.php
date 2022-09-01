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
                          <div class="btn-group" role="group" aria-label="Basic example">
                              <a href="{{route('admin.howItWork')}}" class="btn btn-sm btn-outline-success @if(Request::routeIs('admin.howItWork')) active @endif">
                                  <i class=" mdi mdi-text "></i> SEE ALL
                              </a>
                          </div>

                      </div>
                  </h4>

                        <div class="row justify-content-center">
                            <div class="col-md-12">
                              <form class="forms-sample" role="form" action="{{route('admin.howItWork.update')}}" method="post" enctype="multipart/form-data">
                              @csrf

                                  <input type="hidden" name="id"  value="{{$blog->id}}">

                                  <div class="form-group row">
                                      <label for="title" class="col-sm-2 col-form-label">Icon</label>
                                      <div class="col-sm-10">


                                          <div class="input-group">
                                              <div class="input-group-prepend">
                                                  <span class="input-group-text bg-gradient-success text-white "><?php echo  $blog->icon?></span>
                                              </div>
                                              <input type="text" name="icon" value="{{$blog->icon}}" class="form-control" id="icon" placeholder="Icon">

                                          </div>
                                          @if ($errors->has('icon'))
                                              <p class="text-danger">{{ $errors->first('icon') }}</p>
                                          @endif
                                      </div>
                                  </div>



                                <div class="form-group row">
                                  <label for="title" class="col-sm-2 col-form-label">Title</label>
                                  <div class="col-sm-10">
                                    <input type="text" name="title" value="{{$blog->title}}"   class="form-control" id="title" placeholder="Title">
                                    @if ($errors->has('title'))
                                        <p class="text-danger">{{ $errors->first('title') }}</p>
                                    @endif
                                  </div>
                                </div>

                                  <div class="form-group row">
                                      <label for="title" class="col-sm-2 col-form-label">Details</label>
                                      <div class="col-sm-10">

                                          <input type="text" name="details" value="{{$blog->details}}"   class="form-control" id="details" placeholder="details">

                                          @if ($errors->has('details'))
                                              <p class="text-danger">{{ $errors->first('details') }}</p>
                                          @endif
                                      </div>
                                  </div>


                                

                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
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


@section('script')
@stop
