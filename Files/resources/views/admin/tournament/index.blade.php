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
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic">
                                <a href="#0"
                        data-toggle="modal" data-target="#myModal"
                        data-act="Add New"
                        data-name=""
                        data-id="0"
                                   class="btn btn-sm btn-outline-success edit_button  active ">
                                    <i class="mdi mdi-trophy-outline"></i> Add New
                                </a>
                            </div>
                        </div>
                    </h4>

                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $k=>$mac)
                                <tr>
                                    <td  data-label="SL">{{++$k}}</td>
                                    <td  data-label="Name">{{$mac->name}}</td>
                                    <td  data-label="Status">
                                        <label class="badge badge-{{ $mac->status ==0 ? 'warning' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</label>
                                    </td>
                                    <td  data-label="Action">
                                        <button type="button" class="btn btn-gradient-danger btn-rounded btn-icon edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="Edit"
                                                data-name="{{$mac->name}}"
                                                data-status="{{$mac->status}}"
                                                data-id="{{$mac->id}}">
                                            <i class="mdi mdi-lead-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>


    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="action_act"></span> Tournament</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{route('update.events')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control action_id" type="hidden" name="id">
                        <input class="form-control input-lg action_name" name="name" placeholder="Tournament Name" required>
                        <br>
                    </div>
                    <div class="form-group">
                        <select name="status" id="event-status" class="form-control input-lg action_status" placeholder="Select Status" required>
                            <option value="1" selected>Active</option>
                            <option value="0">DeActive</option>
                        </select>
                        <br>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-gradient-success">Save changes</button>

                    <button type="button" class="btn btn-gradient-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
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

                 var name = $(this).data('name');
                 var status = $(this).data('status');
                 var id = $(this).data('id');
                 var act = $(this).data('act');

                 $(".action_id").val(id);
                 $(".action_name").val(name);
                 $(".action_status").val(status).attr('selected', 'selected');
                 $(".action_act").text(act);

             });
         });
     })(jQuery);
    </script>
@stop
