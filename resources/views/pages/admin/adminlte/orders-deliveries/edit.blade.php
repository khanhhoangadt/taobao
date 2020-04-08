@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'orders-deliveries'] )

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
    OrdersDelivery | Admin | {{ config('site.name') }}
@stop

@section('header')
    OrdersDelivery
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\OrdersDeliveryController@index') !!}"><i class="fa fa-files-o"></i> OrdersDelivery</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $ordersDelivery->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\OrdersDeliveryController@store') !!} @else {!! action('Admin\OrdersDeliveryController@update', [$ordersDelivery->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\OrdersDeliveryController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                                                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="order_id">@lang('admin.pages.orders-deliveries.columns.order_id')</label>
                                    <input type="number" min="0" class="form-control m-input" name="order_id" id="order_id" required placeholder="@lang('admin.pages.orders-deliveries.columns.order_id')" value="{{ old('order_id') ? old('order_id') : $ordersDelivery->order_id }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="delivery_code_id">@lang('admin.pages.orders-deliveries.columns.delivery_code_id')</label>
                                    <input type="number" min="0" class="form-control m-input" name="delivery_code_id" id="delivery_code_id" required placeholder="@lang('admin.pages.orders-deliveries.columns.delivery_code_id')" value="{{ old('delivery_code_id') ? old('delivery_code_id') : $ordersDelivery->delivery_code_id }}">
                                </div>
                            </div>
                        </div>
                                                </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
