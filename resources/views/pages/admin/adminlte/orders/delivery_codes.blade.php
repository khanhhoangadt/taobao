@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'orders'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin/adminlte') !!}"></script>
@stop

@section('title')
@stop

@section('header')
    Order | Admin | {{ config('site.name') }}
@stop

@section('breadcrumb')
    <li class="active">Order</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
            <div class="col-sm-6">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\OrderController@createDeliveryCode', $orderId) !!}"
                               class="btn btn-block btn-primary btn-sm"
                               style="width: 125px;">Tạo mới</a>
                        </p>
                    </h3>
                    <br>
                </div>
                <div class="col-md-7">
                    <form method="get" accept-charset="utf-8" action="{!! action('Admin\OrderController@index') !!}">
                        {!! csrf_field() !!}
                    </form>
                </div>
            </div>
        </div>

        <div class="box-body" style=" overflow-x: scroll; ">
            <table class="table table-bordered logs-system">
                <thead>
                    <tr>
                        <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Mã Vận đơn') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Khối lượng') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Trạng thái') !!}</th>
                        <th>{!! \PaginationHelper::sort('time', 'Thời gian tạo' ) !!}</th>
                        <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $deliveryCodes as $deliveryCode )
                        <tr>
                            <td>{{ $deliveryCode->id }}</td>
                            <td>{{ $deliveryCode->code }}</td>
                            <td>{{ $deliveryCode->weight }}</td>
                            <td>
                                @if ($deliveryCode->status == 1)
                                <span style="color:#DC143C">Chưa nhận hàng</span>
                                @elseif($deliveryCode->status == 2)
                                <span style="color:#FFA500">Đã nhận hàng</span>
                                @elseif($deliveryCode->status == 3)
                                <span style="color:#483D8B">Đã giao hàng cho khách</span>
                                @endif
                            </td>
                            <td>{{ $deliveryCode->created_at }}</td>
                            <td>
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\OrderController@destroyDeliveryCode', $deliveryCode->id) !!}">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
