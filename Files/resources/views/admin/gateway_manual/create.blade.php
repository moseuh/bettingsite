@extends('admin.layout.master')
@section('import-css')
@stop
@section('content')

    <div class="page-header">
        <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi  mdi-wallet  "></i>
              </span> {{$page_title}} </h3>
        <a class="btn btn-success" href="{{ route('admin.deposit.manual.index') }}"><i class="fa fa-fw fa-eye"></i>All Method</a>


    </div>

    <div class="row">

        <div class="col-md-12">
            @include('errors.error')
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <form action="{{ route('admin.deposit.manual.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="payment-method-item">
                            <div class="payment-method-header d-flex flex-wrap">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"
                                             style="background-image: url('{{getImage(imagePath()['gateway']['path'])}}')"></div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input type="file" name="image" class="profilePicUpload" id="image"
                                               accept=".png, .jpg, .jpeg"/>
                                        <label for="image" class="bg-primary text-white"><i class="fa fa-pencil"></i></label>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="row mt-1 ">
                                        <div class="col-md-4 form-group">
                                            <label class="w-100 font-weight-bold">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Method Name" name="name"
                                                   value="{{ old('name') }}"/>
                                        </div>

                                        <div class="col-md-4 form-group">
                                            <div class="input-group">
                                                <label class="w-100 font-weight-bold">Currency <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="currency" class="form-control border-radius-5"
                                                       value="{{ old('currency') }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-md-4 form-group">
                                            <label class="w-100 font-weight-bold">Rate <span
                                                    class="text-danger">*</span></label>

                                            <div class="input-group has_append">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">1 {{ $basic->currency }} =</div>
                                                </div>
                                                <input type="text" class="form-control" placeholder="0" name="rate"
                                                       value="{{ old('rate') }}"/>
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><span class="currency_symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="w-100 font-weight-bold">Delay <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="delay" class="form-control border-radius-5"
                                                   value="{{ old('delay') }}"/>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="payment-method-body">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="card border-primary">
                                            <h5 class="card-header bg-primary text-white">Range</h5>
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <label class="w-100 font-weight-bold">Minimum Amount <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ $basic->currency }}</div>
                                                    </div>
                                                    <input type="text" class="form-control" name="min_amount"
                                                           placeholder="0" value="{{ old('min_amount') }}"/>
                                                </div>
                                                <div class="input-group">
                                                    <label class="w-100 font-weight-bold">Maximum Amount <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ $basic->currency }}</div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="0"
                                                           name="max_amount" value="{{ old('max_amount') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card border-primary">
                                            <h5 class="card-header bg-primary text-white">Charge</h5>
                                            <div class="card-body">
                                                <div class="input-group mb-3">
                                                    <label class="w-100 font-weight-bold">Fixed Charge <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">{{ $basic->currency }}</div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="0"
                                                           name="fixed_charge" value="{{ old('fixed_charge') }}"/>
                                                </div>
                                                <div class="input-group">
                                                    <label class="w-100 font-weight-bold">Percent Charge <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">%</div>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="0"
                                                           name="percent_charge" value="{{ old('percent_charge') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card  border-dark my-3">

                                            <h5 class="card-header bg-dark text-white">Deposit Instruction</h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea rows="4" class="form-control border-radius-5 " id="summernote"
                                                              name="instruction">{{ old('instruction') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border-dark">
                                            <h5 class="card-header bg-dark  text-white">User data
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-light  float-right addUserData"><i
                                                        class="fa fa-fw la-plus"></i>Add New
                                                </button>
                                            </h5>

                                            <div class="card-body">
                                                <div class="row addedField">
                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Save Method</button>
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
                $('#summernote').summernote({
                    placeholder: 'Write Something...',
                    tabsize: 2,
                    height: 400
                });
            });

        })(jQuery);

    </script>


    <script>
        $('input[name=currency]').on('input', function () {
            $('.currency_symbol').text($(this).val());
        });
        $('.addUserData').on('click', function () {
            var html = `
                <div class="col-md-12 user-data">
                    <div class="form-group has_append">
                        <div class="input-group">

                            <input name="field_name[]" class="form-control" type="text" required placeholder="Field Name">

                            <select name="type[]"  class="form-control">
                                <option value="text">Input Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="file">File upload</option>
                            </select>

                            <select name="validation[]"  class="form-control">
                                <option value="required">Required</option>
                                <option value="nullable">Optional</option>
                            </select>

                            <span class="input-group-btn">
                                <button class="btn btn-danger  removeBtn" type="button">
                                    <i class="fa fa-times"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>`;
            $('.addedField').append(html)
        });

        $(document).on('click', '.removeBtn', function () {
            // $(this).parents('.user-data').remove();
            $(this).closest('.input-group').remove();
        });

        @if(old('currency'))
        $('input[name=currency]').trigger('input');
        @endif
    </script>
@stop
