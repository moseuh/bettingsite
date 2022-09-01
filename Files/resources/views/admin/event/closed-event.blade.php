@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-trophy-outline"></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">


                    @include('errors.error')


                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Event</th>
                            <th scope="col">Tournament</th>
                            <th scope="col" class="w-15p">Total Predict Amount</th>
                            <th scope="col">STATUS</th>
                            <th scope="col">Closed Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matches as $k=>$mac)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Event">{{$mac->name}}</td>
                                <td data-label="Tournament">
                                    <strong>{{($mac->event) ? $mac->event->name : 'N/A'}}</strong>
                                </td>


                                <td data-label="Total Predict Amount">
                                    <strong>{{$mac->totalBetInvests()}} {{$basic->currency }}</strong>
                                </td>

                                <td data-label="STATUS">

                                    <label class="badge badge-gradient-{{ $mac->status ==2 ? 'danger' : 'success' }}">{{ $mac->status == 2 ? 'Closed' : 'Active' }}</label>
                                </td>

                                <td data-label="Closed Time">
                                    {{Carbon\carbon::parse($mac->end_date)->format('d M Y H:i A') }}
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>





                </div>
                <div class="card-footer">
                    {!! $matches->links() !!}
                </div>
            </div>
        </div>


    </div>



@endsection


@section('script')

@stop
