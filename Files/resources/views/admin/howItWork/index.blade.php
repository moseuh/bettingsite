@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-image-album"></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">


        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title mb-5">
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic">
                                <a href="{{route('admin.howItWork.create')}}"
                                   class="btn btn-sm btn-outline-success   active ">
                                    <i class="mdi mdi-plus-circle"></i> Add New
                                </a>
                            </div>
                        </div>
                    </h4>

                    @include('errors.error')

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Details</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($slider as $k=>$data)
                                <tr>
                                    <td data-label="Title">{{$data->title}}</td>
                                    <td data-label="Details">@php echo str_limit(strip_tags($data->details),100) @endphp</td>

                                    <td  data-label="Action">
                                        <a href="{{route('admin.howItWork.edit',[$data->id])}}"
                                                class="btn btn-gradient-info btn-rounded btn-icon  pt-12">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        <button type="button"
                                                class="btn btn-gradient-danger btn-rounded btn-icon edit_button"
                                                data-toggle="modal" data-target="#myModal"
                                                data-act="DELETE"
                                                data-id="{{$data->id}}">
                                            <i class="mdi mdi-trash-can-outline"></i>
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
                    <h5 class="modal-title"><span class="action_act"></span> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="post" action="{{route('admin.howItWork.delete')}}">
                {{ csrf_field() }}
                <div class="modal-body">
                        <p>Are you want to delete?</p>
                    <input class="form-control action_id" type="hidden" name="id">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn  btn-gradient-danger">Delete</button>

                    <button type="button" class="btn btn-gradient-secondary" data-dismiss="modal">Close</button>
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
                 var id = $(this).data('id');
                 var act = $(this).data('act');
                 $(".action_id").val(id);
                 $(".action_act").text(act);
             });
         });

     })(jQuery);
    </script>
@stop
