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
                            <a href="{!! URL::action('Admin\OrderController@create') !!}"
                               class="btn btn-block btn-primary btn-sm"
                               style="width: 125px;">Tạo mới</a>
                        </p>
                    </h3>
                    <br>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
                </div>
                <div class="col-md-7">
                    <form method="get" accept-charset="utf-8" action="{!! action('Admin\OrderController@index') !!}">
                        {!! csrf_field() !!}
                        <div class="row search-input">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <div class="search-input-text">
                                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm" id="keyword" value="{{ $keyword }}">
                                    <button type="submit" class="btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
                </div>

                <div class="col-md-5 wrap-top-pagination">
                    <div class="heading-page-pagination">
                        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], ['keyword' => $keyword], $count, 'shared.topPagination') !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body" style=" overflow-x: scroll; ">
            <table class="table table-bordered logs-system">
                <thead>
                    <tr>
                        <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                        <th>{!! \PaginationHelper::sort('code', 'Mã hóa đơn') !!}</th>
                        <th>{!! \PaginationHelper::sort('deliveried_money', 'Tiền đã chuyển') !!}</th>
                        <th>{!! \PaginationHelper::sort('total_money', 'Tổng tiền' ) !!}</th>
                        <th>{!! \PaginationHelper::sort('time', 'Thời gian tạo' ) !!}</th>
                        <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $orders as $order )
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->deliveried_money }}</td>
                            <td>{{ $order->total_money }}</td>
                            <td>{{ $order->time }}</td>
                            <td>
                                <a href="{!! URL::action('Admin\OrderController@show', $order->id) !!}" class="btn btn-block btn-primary btn-xs">Chỉnh sửa</a>
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\OrderController@destroy', $order->id) !!}">Xóa</a>
                                <a href="{!! URL::action('Admin\OrderController@listDeliveryCode', $order->id) !!}" class="btn btn-block btn-success btn-xs">Mã vận đơn</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], ['keyword' => $keyword]) !!}
        </div>
    </div>
@stop