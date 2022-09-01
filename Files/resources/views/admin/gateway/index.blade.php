@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi  mdi-wallet  "></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">
                    <h4 class="card-title mb-5">
                        {{$page_title}}


                    </h4>

                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">STATUS</th>
                            <th scope="col" class="w-18p">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gateways as $k=>$data)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Name">
                                    {{$data->name}}<br>

                                </td>


                                <td data-label="Status">
                                    <label class="badge  badge-gradient-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</label>
                                </td>
                                <td data-label="Action">
                                    <div class="template-demo d-flex  flex-nowrap">
                                        <a href="{{route('payment-method.edit',[$data->id])}}"
                                           class="btn btn-gradient-info btn-sm btn-rounded btn-icon pt-12 tooltip-styled"
                                           data-tooltip-content="Edit Gateway">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>



                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>


    </div>



@endsection


@section('script')
@stop
