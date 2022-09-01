@extends('admin.layout.master')
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
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <form class="forms-sample" role="form" action="" method="post"
                                  enctype="multipart/form-data">
                                @csrf


                                <div class="form-group row">
                                    <div class="col-md-3 offset-md-3">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                        <img class="w-215"
                                                             src="{{ asset('public/images/logo/logo.png') }}/"
                                                             alt="...">
                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215"></div>
                                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                                class="fa fa-file-image-o"></i> Select logo</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                                class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="logo" accept="image/*">
                                                </span>
                                                        <a href="#"
                                                           class="btn btn-danger fileinput-exists bold uppercase"
                                                           data-dismiss="fileinput"><i class="fa fa-trash"></i>
                                                            Remove</a>
                                                    </div>
                                                </div>

                                                <br>
                                                <code>Logo must be png, size 210 *60 px</code>

                                                @if ($errors->has('logo'))
                                                    <p class="text-danger">{{ $errors->first('logo') }}</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 ">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                        <img class="w-215"
                                                             src="{{ asset('public/images/logo/footer-logo.png') }}/"
                                                             alt="...">
                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215"></div>
                                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                                class="fa fa-file-image-o"></i> Select footer logo</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                                class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="footer-logo" accept="image/*">
                                                </span>
                                                        <a href="#"
                                                           class="btn btn-danger fileinput-exists bold uppercase"
                                                           data-dismiss="fileinput"><i class="fa fa-trash"></i>
                                                            Remove</a>
                                                    </div>
                                                </div>

                                                <br>
                                                <code>Logo must be png, size 210 *60 px</code>

                                                @if ($errors->has('logo'))
                                                    <p class="text-danger">{{ $errors->first('logo') }}</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail w-215 h-215" data-trigger="fileinput">
                                                        <img class="w-215 h-215"
                                                             src="{{ asset('public/images/logo/favicon.png') }}/"
                                                             alt="...">
                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail h-215 w-215"></div>
                                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                                class="fa fa-file-image-o"></i> Select favicon</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                                class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="favicon" accept="image/*">
                                                </span>
                                                        <a href="#"
                                                           class="btn btn-danger fileinput-exists bold uppercase"
                                                           data-dismiss="fileinput"><i class="fa fa-trash"></i>
                                                            Remove</a>
                                                    </div>
                                                </div>

                                                @if ($errors->has('favicon'))
                                                    <p class="text-danger">{{ $errors->first('favicon') }}</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="title" class="col-sm-3 col-form-label">Site Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="sitename" value="{{$basic->sitename}}"
                                               class="form-control" id="title" placeholder="Site Name">
                                        @if ($errors->has('sitename'))
                                            <p class="text-danger">{{ $errors->first('sitename') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="email" value="{{$basic->email}}" class="form-control"
                                               id="email" placeholder="Email Address">
                                        @if ($errors->has('email'))
                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">Contact Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="phone" value="{{$basic->phone}}" class="form-control"
                                               id="phone" placeholder="Contact Number">
                                        @if ($errors->has('phone'))
                                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="phone" class="col-sm-3 col-form-label">Address </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="address" value="{{$basic->address}}"
                                               class="form-control" id="address" placeholder="Address">
                                        @if ($errors->has('address'))
                                            <p class="text-danger">{{ $errors->first('address') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="footer_about" class="col-sm-3 col-form-label">Footer About </label>
                                    <div class="col-sm-9">
                                        <textarea name="footer_about" id="footer_about" class="form-control"
                                                  rows="10">{{$basic->footer_about}}</textarea>
                                        @if ($errors->has('footer_about'))
                                            <p class="text-danger">{{ $errors->first('footer_about') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-3 col-form-label">Meta keywords </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="meta_keywords" value="{{$basic->meta_keywords}}"
                                               class="form-control" id="meta_keywords" placeholder="Meta Keywords">
                                        @if ($errors->has('meta_keywords'))
                                            <p class="text-danger">{{ $errors->first('meta_keywords') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="meta_description" class="col-sm-3 col-form-label">Meta
                                        Description </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="meta_description" value="{{$basic->meta_description}}"
                                               class="form-control" id="meta_description"
                                               placeholder="Meta Description">
                                        @if ($errors->has('meta_description'))
                                            <p class="text-danger">{{ $errors->first('meta_description') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Save</button>
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

