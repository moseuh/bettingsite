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
                        @include('errors.error')
                        <div class="col-md-12">
                            <form class="forms-sample" role="form" action="{{route('siteControl')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf


                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">About Us</label>
                                    <div class="col-sm-10">
                                        <textarea name="about" id="summernote" rows="20">{{$basic->about}}</textarea>
                                        @if ($errors->has('about'))
                                            <p class="text-danger">{{ $errors->first('about') }}</p>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
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


@section('script')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $('#summernote').summernote({
                    placeholder: 'Write Something...',
                    tabsize: 2,
                    height: 400
                });
            });

        })(jQuery);

    </script>
@stop
