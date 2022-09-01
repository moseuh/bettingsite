@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi  mdi-trophy-outline  "></i>
              </span> {{$page_title}} </h3>


    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">


                <div class="card-body">
                    <h4 class="card-title mb-5">
                        <div class="float-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{route('add.match')}}"
                                   class="btn btn-sm btn-outline-success @if(Request::routeIs('add.match')) active @endif">
                                    <i class=" mdi mdi-plus "></i> Create Event
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
                            <th scope="col">Tournament</th>
                            <th scope="col">Event Schedule</th>
                            <th scope="col">STATUS</th>
                            <th scope="col" class="w-18p">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($matches as $k=>$mac)
                            <tr>
                                <td data-label="SL">{{++$k}}</td>
                                <td data-label="Name">
                                    {{$mac->name}}<br>

                                    @if($mac->betInvests->sum('invest_amount') > 0)
                                        <p class="text-danger">Predict Amount
                                            :{{number_format($mac->betInvests->where('status','!=',2)->sum('invest_amount'),2) }} {{$basic->currency}}</p>
                                    @endif
                                </td>

                                <td data-label="Tournament">
                                    <strong>{{$mac->event->name}}</strong>
                                </td>

                                <td data-label="Event Schedule">
                                    {{ date('d M y h:i A', strtotime($mac->start_date)) }} <label class="badge  badge-gradient-info"> To </label>
                                    {{date('d M y h:i A', strtotime($mac->end_date))}}
                                </td>


                                <td data-label="Status">
                                    <label class="badge  badge-gradient-{{ $mac->status ==0 ? 'danger' : 'success' }}">{{ $mac->status == 0 ? 'Deactive' : 'Active' }}</label>
                                </td>
                                <td data-label="Action">
                                    <div class="template-demo d-flex  flex-nowrap">
                                        <a href="{{route('edit.match', $mac->id )}}"
                                           class="btn btn-gradient-info btn-sm btn-rounded btn-icon pt-12 tooltip-styled"
                                           data-tooltip-content="Edit Event">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        @php
                                            $totalQuestions = $mac->questions()->count();
                                            $totalOptions = $mac->options()->count();
                                        @endphp
                                        <a href="{{route('view.question', $mac->id )}}"
                                           class="btn btn-gradient-primary btn-sm btn-rounded btn-icon text-decoration-none pt-12 tooltip-styled"
                                           data-tooltip-content=" Click To Add More Question">
                                            @if($totalQuestions < 10)
                                            @php echo  "<i class='mdi mdi-numeric-".$totalQuestions."-box'></i>"; @endphp
                                            @else
                                                <span>{{$totalQuestions}}</span>
                                            @endif
                                        </a>


                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="card-footer">
                    {{$matches->links()}}
                </div>
            </div>
        </div>


    </div>



@endsection


@section('script')

@stop
