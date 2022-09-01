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
                        Manage Balance
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form class="forms-sample" role="form" action="{{route('user.balance.update',[$user->id])}}" method="post" enctype="multipart/form-data">
                                @csrf




                                <div class="form-group row">
                                    <label for="operation" class="col-sm-3 col-form-label">Operation</label>
                                    <div class="col-sm-9">

                                        <select name="operation" id="operation" class="form-control">
                                            <option value="on">  Add Balance</option>
                                            <option value="off">Subtract Balance</option>
                                        </select>
                                        @if ($errors->has('operation'))
                                            <p class="text-danger">{{ $errors->first('operation') }}</p>
                                        @endif
                                    </div>
                                </div>





                                <div class="form-group row">
                                    <label for="amount" class="col-sm-3 col-form-label">Amount</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="amount" class="form-control" value="{{old('amount')}}" id="amount" placeholder="Amount">
                                        @if ($errors->has('amount'))
                                            <p class="text-danger">{{ $errors->first('amount') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="message" class="col-sm-3 col-form-label">Message </label>
                                    <div class="col-sm-9">
                                        <textarea name="message" id="message" rows="5" class="form-control" placeholder="Message">{{old('message')}}</textarea>
                                        @if ($errors->has('message'))
                                            <p class="text-danger">{{ $errors->first('message') }}</p>
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



@section('import-js')
@stop

@section('script')


@stop
