@extends('layout')

@section('css')

@stop
@section('content')

@include('partials.breadcrumb')



<div class="faq-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="accordion" id="accordionExample1">
                    @foreach($faqs as $k => $data)
                    <div class="card border-1p">
                        <div class="card-header" id="heading{{$data->id}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link @if($k == 0) collapsed @endif btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$data->id}}" aria-expanded="true" aria-controls="collapse{{$data->id}}">
                                    {{$data->title}}
                                </button>
                            </h2>
                        </div>
                        <div id="collapse{{$data->id}}" class="collapse @if($k == 0) show @endif" aria-labelledby="heading{{$data->id}}" data-parent="#accordionExample1">
                            <div class="card-body">
                                <?php echo  $data->details; ?>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('js')

@stop
