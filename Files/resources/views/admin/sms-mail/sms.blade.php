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
                        Twilio API SMS INFORMATION
                    </h4>


                    @include('errors.error')
                    <form role="form" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>SMS FROM</label>
                                <input type="text" name="sms_from" id="sms_from" class="form-control"
                                       value="{{$basic->sms_from}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Twilio SID</label>
                                <input type="text" name="sid" id="sid" class="form-control"
                                       value="{{$basic->sid}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Twilio SMS API TOKEN</label>
                                <input type="text" name="api_token" id="api_token" class="form-control"
                                       value="{{$basic->api_token}}">
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

