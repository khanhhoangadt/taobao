@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'delivery-codes'] )

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
    DeliveryCode | Admin | {{ config('site.name') }}
@stop

@section('breadcrumb')
    <li class="active">DeliveryCode</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
            <div class="col-sm-6">
                    <br>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
                </div>
                <div class="col-md-7">
                    <form method="get" accept-charset="utf-8" action="{!! action('Admin\DeliveryCodeController@index') !!}">
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
            <form action="{!! action('Admin\DeliveryCodeController@import') !!}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-md-2" style="padding-left: 25px;">
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered logs-system">
                <thead>
                    <tr>
                        <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                        <th>{!! \PaginationHelper::sort('code', 'Mã vận đơn') !!}</th>
                        <th>{!! \PaginationHelper::sort('weight', 'Cân nặng') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Người cập nhật gần nhất') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Khách hàng') !!}</th>
                        <th>{!! \PaginationHelper::sort('status', 'Trạng thái') !!}</th>                        
                        <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $deliveryCodes as $deliveryCode )
                        <tr>
                            <td>{{ $deliveryCode->id }}</td>
                            <td>{{ $deliveryCode->code }}</td>
                            <td>{{ $deliveryCode->weight }}</td>
                            <td>{{ @$deliveryCode->staff->name }}</td>
                            <td>{{ @$deliveryCode->customer->name }}</td>
                            <td>
                                @if ($deliveryCode->status == 1)
                                <span style="color:#DC143C">Chưa nhận hàng</span>
                                @elseif($deliveryCode->status == 2)
                                <span style="color:#FFA500">Đã nhận hàng</span>
                                @elseif($deliveryCode->status == 3)
                                <span style="color:#483D8B">Đã giao hàng cho khách</span>
                                @endif
                            </td>
                            <td>
                                @if ($deliveryCode->status != 3)
                                <a href="{!! URL::action('Admin\DeliveryCodeController@show', $deliveryCode->id) !!}" class="btn btn-block btn-primary btn-xs">Chỉnh sửa</a>
                                @endif
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\DeliveryCodeController@destroy', $deliveryCode->id) !!}">Xóa</a>
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
