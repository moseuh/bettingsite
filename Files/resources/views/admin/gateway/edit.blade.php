@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-wallet"></i>
              </span> {{$page_title}} </h3>
    </div>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title mb-5">
                        Edit {{$page_title}}
                    </h4>

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <form class="forms-sample" role="form" action="{{route('payment-method.update',$gateway)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')


                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="font-weight-bold">Gateway Name</label>
                                            <input type="text" name="name" value="{{$gateway->name}}"   class="form-control" id="name" placeholder="Gateway Name" readonly>
                                            @if ($errors->has('name'))
                                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rate" class="font-weight-bold">Rate</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-gradient-dark text-white">1 {{$basic->currency}} =</span>
                                                </div>

                                                <input type="text" name="rate" value="{{round($gateway->rate,2)}}"   class="form-control" id="rate" placeholder="Rate">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$gateway->currency}}</span>
                                                </div>
                                            </div>

                                            @if ($errors->has('rate'))
                                                <p class="text-danger">{{ $errors->first('rate') }}</p>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="currency" class="font-weight-bold">Gateway Currency</label>
                                            <select name="currency" id="currency" class="form-control">
                                                <option value="">Select Currency</option>
                                                @foreach($gate_currency as $k => $data)
                                                <option value="{{$k}}" @if($gateway->currency == $k) selected @endif>{{$k}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('currency'))
                                                <p class="text-danger">{{ $errors->first('currency') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="symbol" class="font-weight-bold">Gateway Symbol</label>
                                            <input type="text" name="symbol" value="{{$gateway->symbol}}"   class="form-control" id="symbol" placeholder="Symbol">
                                            @if ($errors->has('symbol'))
                                                <p class="text-danger">{{ $errors->first('symbol') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_amount" class="font-weight-bold">Minimum Amount</label>
                                            <div class="input-group">
                                                <input type="text" name="min_amount" value="{{round($gateway->min_amount,2)}}"   class="form-control" id="min_amount" placeholder="Minimum Amount">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('min_amount'))
                                                <p class="text-danger">{{ $errors->first('min_amount') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_amount" class="font-weight-bold">Maximum Amount</label>
                                            <div class="input-group">
                                                <input type="text" name="max_amount" value="{{round($gateway->max_amount,2)}}"   class="form-control" id="max_amount" placeholder="Maximum Amount">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('max_amount'))
                                                <p class="text-danger">{{ $errors->first('max_amount') }}</p>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="percent_charge" class="font-weight-bold">Percent Charge</label>
                                            <div class="input-group">
                                                <input type="text" name="percent_charge" value="{{round($gateway->percent_charge,2)}}"   class="form-control" id="percent_charge" placeholder="Percent Charge">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">%</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('percent_charge'))
                                                <p class="text-danger">{{ $errors->first('percent_charge') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fixed_charge" class="font-weight-bold">Fixed Charge</label>
                                            <div class="input-group">
                                                <input type="text" name="fixed_charge" value="{{round($gateway->fixed_charge,2)}}"   class="form-control" id="fixed_charge" placeholder="Fixed Charge">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-gradient-success text-white ">{{$basic->currency}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('fixed_charge'))
                                                <p class="text-danger">{{ $errors->first('fixed_charge') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="font-weight-bold">Status</label>
                                            <div class="form-check form-check-success">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="status" class="form-check-input" @if($gateway->status == 1) checked @endif>  Active <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                    </div>

                                
                                </div>



                                 @if($gateway->method_code < 1000 && $gateway->extra)
                                <div class="payment-method-body">
                                    <h4 class="my-3">Configurations</h4>
                                    <div class="row">
                                        @foreach($gateway->extra as $key => $param)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="min_amount" class="font-weight-bold">{{ @$param->title }}</label>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" value="{{ route($param->value) }}" readonly/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text bg-gradient-success text-white copyInput" data-toggle="tooltip" title="Copy"><i class="fa fa-copy"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif


                                <div class="form-group row">
                                    @foreach(json_decode($gateway->parameter) as $k => $value)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="{{$k}}" class="font-weight-bold">{{strtoupper(str_replace('_',' ',$k))}}</label>

                                            <input type="text" name="{{$k}}" value="{{$value}}"   class="form-control" id="{{$k}}" placeholder="{{strtoupper(str_replace('_',' ',$k))}}">

                                            @if ($errors->has($k))
                                                <p class="text-danger">{{ $errors->first($k) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            @if($gateway->image == null)
                                                <div class="fileinput-new thumbnail w-215 h-215"  data-trigger="fileinput">
                                                    <img class="w-215" src="{{ asset('public/images/user/default.jpg') }}/" alt="...">
                                                </div>
                                            @else
                                                <div class="fileinput-new thumbnail w-215 h-215"  data-trigger="fileinput">
                                                    <img class="w-215" src="{{ asset('public/images/gateways/') }}/{{$gateway->image}}" alt="...">
                                                </div>
                                            @endif

                                            <div class="fileinput-preview fileinput-exists thumbnail w-215 h-215" ></div>
                                            <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                                <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                            </div>
                                        </div>

                                        @if ($errors->has('image'))
                                            <p class="text-danger">{{ $errors->first('image') }}</p>
                                        @endif

                                    </div>
                                </div>




                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-gradient-success btn-block">Update</button>
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



@push('js')

<script>
$('.copyInput').on('click', function(e) {
    var copybtn = $(this);


    var input = copybtn.parent().siblings('input');


    if(input && input.select) {
        input.select();



        try{
            document.execCommand('SelectAll')
            document.execCommand('Copy', false, null);
            input.blur();
            copybtn.addClass('copied');



            setTimeout(function() { copybtn.removeClass('copied'); }, 1000);



              var content = {};

              content.message = 'Copied';
              content.title = 'Success';
              content.icon = 'fa fa-copy';

              $.notify(content,{
                type: 'success',
                placement: {
                  from: 'top',
                  align: 'right'
                },
                showProgressbar: true,
                time: 1000,
                delay: 1000,
              });

        }catch(err) {
            alert('Please press Ctrl/Cmd + C to copy');
        }
    }
});

</script>
@endpush
