@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'orders'] )

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
    Order | Admin | {{ config('site.name') }}
@stop

@section('header')
    Order
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\OrderController@index') !!}"><i class="fa fa-files-o"></i> Order</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $order->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\OrderController@store') !!} @else {!! action('Admin\OrderController@update', [$order->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\OrderController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                                                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Mã vận đơn</label>
                                    <input type="text" class="form-control m-input" name="code" id="code" required placeholder="Mã vận đơn" value="{{ old('code') ? old('code') : $order->code }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="deliveried_money"> Tiền đã chuyển</label>
                                    <input type="number" min="0" class="form-control m-input" name="deliveried_money" id="deliveried_money" required placeholder="Tiền đã chuyển" value="{{ old('deliveried_money') ? old('deliveried_money') : $order->deliveried_money }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="total_money">Tổng tiền</label>
                                    <input type="number" min="0" class="form-control m-input" name="total_money" id="total_money" required placeholder="Tổng tiền" value="{{ old('total_money') ? old('total_money') : $order->total_money }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="admin_user_id">Nhân viên</label>
                                    <input type="number" min="0" class="form-control m-input" name="admin_user_id" id="admin_user_id" required placeholder="Nhân viên" value="{{ old('admin_user_id') ? old('admin_user_id') : $order->admin_user_id }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customer_id">Mã khách hàng</label>
                                    <input type="number" min="0" class="form-control m-input" name="customer_id" id="customer_id" required placeholder="Mã khách hàng" value="{{ old('customer_id') ? old('customer_id') : $order->customer_id }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="time" class="label-datetimepicker">Thời gian</label>
                                    <div class="input-group date datetime-field" style="margin-bottom: 10px;">
                                        <input type="text" class="form-control" style="margin: 0;" name="time" id="time" value="{{ old('time') ? old('time') : $order->time }}">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
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
