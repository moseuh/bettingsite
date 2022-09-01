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
                            <th scope="col">Date</th>
                            <th scope="col">Trx Number</th>
                            <th scope="col">Username</th>
                            <th scope="col">Method</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Charge</th>
                            <th scope="col">After Charge</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Payable</th>
                            @if(request()->routeIs('deposit.pending') )
                                <th scope="col">Action</th>

                            @elseif(request()->routeIs('payment-log') || request()->routeIs('deposit.search') || request()->routeIs('user.paymentLog'))
                                <th scope="col">Status</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($deposits as $deposit)
                            <tr>
                                <td>{{ showDateTime($deposit->created_at) }}</td>
                                <td class="font-weight-bold text-uppercase">{{ $deposit->trx }}</td>
                                <td><a href="{{ route('user.single', $deposit->user_id) }}">{{ $deposit->user->username }}</a></td>
                                <td>{{ $deposit->gateway_currency()->name }}</td>
                                <td class="font-weight-bold">{{ number_format($deposit->amount, $basic->decimal ) }} {{ $basic->currency }}</td>
                                <td class="text-success">{{ number_format($deposit->charge, $basic->decimal)}} {{ $basic->currency }}</td>
                                <td> {{ number_format($deposit->amount+$deposit->charge, $basic->decimal) }}</td>
                                <td> {{ number_format($deposit->rate,$basic->decimal) }}</td>
                                <td class="font-weight-bold">{{ getAmount($deposit->final_amo) }} {{$deposit->method_currency}}</td>

                                @if(request()->routeIs('deposit.pending'))
                                    @php
                                        $details = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <td>

                                        <button
                                            class="approveBtn  pt-0 btn btn-gradient-success btn-sm btn-rounded btn-icon  tooltip-styled"
                                            data-tooltip-content="Approve"
                                            data-id="{{ $deposit->id }}"
                                            data-info="{{$details}}"
                                            data-amount="{{ getAmount($deposit->amount)}} {{ $basic->currency }}"
                                            data-username="{{ $deposit->user->username }}"
                                            data-toggle="tooltip"  data-original-title="Approve">

                                            <i class="mdi mdi-check"></i></button>


                                        <button
                                            class="rejectBtn pt-0 btn btn-gradient-danger btn-sm btn-rounded btn-icon  tooltip-styled"
                                            data-tooltip-content="Reject"

                                            data-id="{{ $deposit->id }}"
                                            data-info="{{$details}}"
                                            data-amount="{{ getAmount($deposit->amount)}} {{ $basic->currency }}"
                                            data-username="{{ $deposit->user->username }}"
                                            data-toggle="tooltip"><i class="mdi mdi-trash-can"></i></button>

                                    </td>
                                @elseif(request()->routeIs('payment-log')  || request()->routeIs('deposit.search') || request()->routeIs('user.paymentLog'))

                                    <td data-label="Status">
                                        @if($deposit->status == 2)
                                            <label class="badge  badge-gradient-warning">Pending</label>
                                        @elseif($deposit->status == 1)
                                            <label class="badge  badge-gradient-success">Approved</label>
                                        @elseif($deposit->status == -2)
                                            <label class="badge  badge-gradient-danger">Rejected</label>
                                        @endif
                                    </td>

                                @endif

                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{$deposits->links()}}


                </div>
            </div>
        </div>


    </div>




    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Deposit Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('deposit.approve')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">

                        <p>Are you sure to <span class="font-weight-bold">approve</span> <span class="font-weight-bold withdraw-amount text-success"></span> deposit of <span class="font-weight-bold withdraw-user"></span>?</p>

                        <ul class="list-group deposit-detail mt-1">
                        </ul>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Deposit Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('deposit.reject')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">

                        <p>Are you sure to <span class="font-weight-bold">reject</span> <span class="font-weight-bold withdraw-amount text-success"></span> deposit of <span class="font-weight-bold withdraw-user"></span>?</p>

                        <ul class="list-group deposit-detail mt-1">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));

            var details = Object.entries($(this).data('info'));
            var list = [];
            var ImgPath = "{{asset(imagePath()['deposit']['path'])}}";


            details.map(function (item, i) {
                if (item[1].type == 'file') {
                    var singleInfo = `<br><img src="${ImgPath}/${item[1].field_name}" alt="..." class="w-100"><br>`;
                } else {
                    var singleInfo = `<span class="font-weight-bold ml-3">${item[1].field_name}</span>  `;
                }
                list[i] = ` <li class="list-group-item my-1"><span class="font-weight-bold "> ${item[0].replace('_', " ")} </span> : ${singleInfo}</li>`
            });

            modal.find('.deposit-detail').html(list);
            modal.modal('show');
        });

        $('.rejectBtn').on('click', function() {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));

            var details = Object.entries($(this).data('info'));
            var list = [];
            var ImgPath = "{{asset(imagePath()['deposit']['path'])}}";

            details.map(function (item, i) {
                if (item[1].type == 'file') {
                    var singleInfo = `<br><br><img src="${ImgPath}/${item[1].field_name}" alt="..." class="w-100"><br>`;
                } else {
                    var singleInfo = `<span class="font-weight-bold ml-3">${item[1].field_name}</span>  `;
                }
                list[i] = ` <li class="list-group-item"><span class="font-weight-bold "> ${item[0].replace('_', " ")} </span> : ${singleInfo}</li>`
            });

            modal.find('.deposit-detail').html(list);

            modal.modal('show');
        });
    </script>
@stop
