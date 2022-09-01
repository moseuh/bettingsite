@extends('user')

@section('css')

@stop
@section('content')


    @include('partials.breadcrumb')

    <div class="faq-section shadow-bg">
        <div class="container">
            @if($basic->withdraw_status == 0)
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-danger text-center">@lang('Withdraw Money DeActive By Admin').</h3>
                    </div>
                </div>
            @else

               <div class="row">
                   <div class="col-md-12">
                       @if ($errors->any())
                           @foreach ($errors->all() as $error)
                               <div>{{$error}}</div>
                           @endforeach
                       @endif
                   </div>

                   @foreach($withdrawMethod as $data)
                       <div class="col-md-3 mb-4">
                           <div class="card card-deposit">
                               <div class="card-header custom-header text-center">
                                   <h4 class="card-title">{{__($data->name)}}</h4>
                               </div>
                               <div class="card-body card-body-deposit">
                                   <img src="{{asset('public/images/withdraw/'. $data->image)}}" class="card-img-top w-100p" alt="{{$data->name}}" >

                               </div>
                               <div class="card-footer custom-footer">
                                   <button type="button"  data-id="{{$data->id}}" data-resource="{{$data}}"
                                      data-min_amount="{{formatter_money($data->withdraw_min)}}"
                                      data-max_amount="{{formatter_money($data->withdraw_max)}}"
                                      data-fix_charge="{{formatter_money($data->fix)}}"
                                      data-percent_charge="{{formatter_money($data->percent)}}"
                                      data-base_symbol="{{$basic->currency}}" class="cartbtn cart btn btn-block deposit" data-toggle="modal" data-target="#exampleModal">
                                       <span>@lang('Withdraw Now')</span></button>
                               </div>
                           </div>
                       </div>
                   @endforeach
               </div>
            @endif
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header custom-modal-header">
                    <h5 class="modal-title method-name  text-white" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger depositLimit"></p>
                        <p class="text-danger depositCharge"></p>
                        <p class="text-info duration"></p>

                        <div class="form-group">
                            <input type="hidden" name="id"  class="id form-control" value="">
                        </div>



                        <div class="form-group">
                            <label><strong>@lang('Enter Amount'):</strong></label>
                            <div class="input-group">
                                <input id="amount" type="text" class="form-control form-control-lg" onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')" name="amount" placeholder="0.00" required=""  value="{{old('amount')}}">

                                <div class="input-group-prepend">
                                    <span class="input-group-text addon-bg currency-addon">{{__($basic->currency_sym)}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-element mt-2">
                            <button type="submit" class="btn btn-block"><span>@lang('Confirm')</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop




@section('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $('.deposit').on('click', function () {

                    var result = $(this).data('resource');
                    var minAmount = $(this).data('min_amount');
                    var maxAmount = $(this).data('max_amount');
                    var baseSymbol = $(this).data('base_symbol');
                    var fixCharge = $(this).data('fix_charge');
                    var percentCharge = $(this).data('percent_charge');

                    var selectedCurr = $("#currency_id").find(':selected').data('select_currency');
                    $('.currency-addon').text(`${baseSymbol}`);


                    var depositLimit = `@lang('Withdraw Limit:') ${minAmount} - ${maxAmount}  ${baseSymbol}`;
                    $('.depositLimit').text(depositLimit);
                    var depositCharge = `@lang('Charge:') ${fixCharge} ${baseSymbol} + ${percentCharge} %`
                    $('.depositCharge').text(depositCharge);
                    $('.method-name').text(`@lang('Withdraw Via ') ${result.name}`);

                    $('.duration').text(`@lang('Recipient Get Amount in ') ${result.duration}`);


                    $('.id').val(result.id);
                });
            });
        })(jQuery);
    </script>

@stop
