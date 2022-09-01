@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi  mdi-wallet  "></i>
              </span> {{$page_title}} </h3>



        <a class="btn btn-success" href="{{ route('admin.deposit.manual.create') }}"><i class="fa fa-fw fa-plus"></i>Add New</a>


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
                            <th scope="col">Gateway</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($gateways as $data)
                            <tr>
                                <td data-label="Name">
                                    {{$data->name}}
                                </td>


                                <td data-label="Status">
                                    <label class="badge  badge-gradient-{{ $data->status ==0 ? 'danger' : 'success' }}">{{ $data->status == 0 ? 'Deactive' : 'Active' }}</label>
                                </td>
                                <td data-label="Action">

                                    <a href="{{route('admin.deposit.manual.edit', $data->alias) }}" class="btn btn-gradient-info btn-sm btn-rounded btn-icon editGatewayBtn pt-12 tooltip-styled" data-tooltip-content="Edit Gateway">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>



                                    @if($data->status == 0)
                                        <button data-toggle="modal" data-target="#activateModal"
                                                class="btn btn-gradient-success btn-sm btn-rounded btn-icon activateBtn pt-0 tooltip-styled"
                                                data-tooltip-content="Enable"
                                                data-code="{{$data->method_code}}"
                                                data-name="{{$data->name}}">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                    @else
                                        <button data-toggle="modal" data-target="#deactivateModal"
                                                class="btn btn-gradient-danger btn-sm btn-rounded btn-icon deactivateBtn pt-0 tooltip-styled"
                                                data-tooltip-content="Disable"

                                                data-code="{{$data->method_code}}"
                                                data-name="{{$data->name}}">
                                            <i class="mdi mdi-eye-off"></i>
                                        </button>
                                    @endif


                                </td>
                            </tr>@empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>


                </div>
            </div>
        </div>


    </div>






    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Method Activation Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.deposit.manual.activate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>Are you sure to activate <span class="font-weight-bold method-name"></span> method?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Activate</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- DEACTIVATE METHOD MODAL --}}
    <div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Method Disable Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('admin.deposit.manual.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p>Are you sure to disable <span class="font-weight-bold method-name"></span> method?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Disable</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        $('.activateBtn').on('click', function () {
            var modal = $('#activateModal');
            modal.find('.method-name').text($(this).data('name'));
            modal.find('input[name=code]').val($(this).data('code'));
        });

        $('.deactivateBtn').on('click', function () {
            var modal = $('#deactivateModal');
            modal.find('.method-name').text($(this).data('name'));
            modal.find('input[name=code]').val($(this).data('code'));
        });
    </script>
@stop
