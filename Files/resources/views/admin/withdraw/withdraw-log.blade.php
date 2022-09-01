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
                            <th scope="col">Username</th>
                            <th scope="col">Withdraw Method</th>
                            <th scope="col">Amount</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $k=>$data)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Username">
                                    <a href="{{route('user.single',$data->user_id)}}">
                                    {{$data->user->username}}
                                    </a>
                                </td>

                                <td data-label="Withdraw Method">
                                    <span class="font-weight-bold text-info"> {{($data->method)? $data->method->name : '' }}</span>
                                </td>



                                <td data-label="Amount">
                                    <span class="font-weight-bold text-success">{{formatter_money($data->amount)}} {{$basic->currency}}</span>
                                </td>


                                <td data-label="Status">
                                    @if($data->status == 1)
                                    <label class="badge  badge-gradient-warning">Pending</label>
                                    @elseif($data->status == 2)
                                    <label class="badge  badge-gradient-success">Paid</label>
                                    @elseif($data->status == -2)
                                    <label class="badge  badge-gradient-danger">Rejected</label>
                                    @endif
                                </td>

                                <td data-label="Date">
                                    {{date('d M, Y h:i A',strtotime($data->created_at))}}
                                </td>
                                <td data-label="Action">
                                    @php
                                    $details = ($data->withdraw_information != null) ? json_encode($data->withdraw_information) : null;
                                    @endphp
                                    <button type="button" class="btn btn-gradient-success btn-rounded btn-icon edit_button"
                                            data-toggle="modal" data-target="#myModal"
                                            data-route="{{route('withdraw-action',$data->id)}}"
                                            data-info="{{$details}}"
                                            data-id="{{$data->id}}">
                                        @if(Request::routeIs('withdraw-request'))
                                        <i class="mdi mdi-lead-pencil"></i>
                                            @else
                                        <i class="mdi mdi-eye"></i>
                                        @endif
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{$logs->links()}}


                </div>
            </div>
        </div>


    </div>





    <!-- Modal for Edit button -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Withdraw Info </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <ul class="list-group withdraw-detail">
                    </ul>
                </div>
                <div class="modal-footer">
                    @if(Request::routeIs('withdraw-request'))
                    <form role="form" method="POST" class="actionRoute" action="" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{method_field('put')}}

                        <input type="hidden" class="action_id" name="id">
                        <button type="submit" class="btn btn-success" name="status" value="2">Approve</button>

                        <button type="submit" class="btn btn-danger" name="status" value="-2">Reject</button>
                    </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                    </button>
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
                $(document).on("click", '.edit_button', function (e) {
                    var id = $(this).data('id');
                    $(".action_id").val(id);
                    $(".actionRoute").attr('action', $(this).data('route'));
                    var details = Object.entries($(this).data('info'));

                    var list = [];
                    var ImgPath = "{{asset('public/images/')}}";
                    details.map(function (item, i) {
                        if (item[1].type == 'file') {
                            var singleInfo = `<br><img src="${ImgPath}/${item[1].field_name}" alt="..." class="w-100p">`;
                        } else {
                            var singleInfo = `<span class="font-weight-bold ml-3">${item[1].field_name}</span>  `;
                        }
                        list[i] = ` <li class="list-group-item"><span class="font-weight-bold "> ${item[0].replace('_', " ")} </span> : ${singleInfo}</li>`
                    });

                    $('.withdraw-detail').html(list);
                });
            });
        })(jQuery)
    </script>
@stop
