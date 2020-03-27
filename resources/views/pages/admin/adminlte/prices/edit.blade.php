@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'prices'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $('#cover-image').change(function (event) {
                $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
    Price | Admin | {{ config('site.name') }}
@stop

@section('header')
    Price
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PriceController@index') !!}"><i class="fa fa-files-o"></i> Price</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $price->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="@if($isNew) {!! action('Admin\PriceController@store') !!} @else {!! action('Admin\PriceController@update', [$price->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\PriceController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                                                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customer_id">Mã khách hàng</label>
                                    <input type="number" min="0" class="form-control m-input" name="customer_id" id="customer_id" required placeholder="Mã khách hàng" value="{{ old('customer_id') ? old('customer_id') : $price->customer_id }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="qty">Số lượng</label>
                                    <input type="number" min="0" class="form-control m-input" name="qty" id="qty" required placeholder="Số lượng" value="{{ old('qty') ? old('qty') : $price->qty }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="price">Giá vận chuyển</label>
                                    <input type="number" min="0" class="form-control m-input" name="price" id="price" required placeholder="Giá vận chuyển" value="{{ old('price') ? old('price') : $price->price }}">
                                </div>
                            </div>
                        </div>
                                                </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">Lưu</button>
            </div>
        </div>
    </form>
@stop
