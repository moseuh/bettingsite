@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-email "></i>
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
                                <a href="{{route('sms-setting')}}" class="btn btn-sm btn-outline-success @if(Request::routeIs('sms-setting')) active @endif">
                                   SMS Settings
                                </a>
                            </div>

                        </div>
                    </h4>

                    @include('errors.error')
                    <table class="table ">
                        <thead>
                        <tr>
                            <th> CODE </th>
                            <th> DESCRIPTION </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td> <pre>[[name]]</pre> </td>
                            <td> Users Name. Will Pull From Database and Use in EMAIL text</td>
                        </tr>

                        <tr>
                            <td> <pre>[[message]]</pre> </td>
                            <td> Details Text From Script</td>
                        </tr>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">
                        Email Template
                    </h4>

                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-body">
                            <div class="form-group">
                                <label>Email Sent Form</label>
                                <input type="email" name="esender" class="form-control input-lg" value="{{$temp->esender}}">
                            </div>

                            <div class="form-group">
                                <label>Email Message</label>
                                <textarea class="form-control" name="emessage" id="summernote" rows="10">
									{{$temp->emessage}}
								</textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-gradient-success btn-block">Update</button>
                        </div>
                    </form>
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
