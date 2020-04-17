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
                <div class="col-md-12">
                    <h3 class="box-title">
                        <p class="text-right">
                            <a href="{!! URL::action('Admin\OrderController@createDeliveryCode') !!}"
                               class="btn btn-block btn-primary btn-sm"
                               style="width: 125px;">Tạo mới</a>
                        </p>
                    </h3>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <form method="get" accept-charset="utf-8" action="{!! action('Admin\OrderController@listDeliveryCode') !!}">
                        {!! csrf_field() !!}
                        <div class="row search-input">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <div class="search-input-text">
                                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo mã vận đơn" id="keyword" value="{{ $keyword }}">
                                    <button type="submit" class="btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
                </div>
            </div>
            @if ($authUser->hasRole(\App\Models\AdminUserRole::ROLE_CUSTOMER, false))
            @if($totalMoney != 0)
            <span style="padding-left: 5px;">Bạn có các mã vận đơn: <span style="color:red">{{$strDeliveryCode}}</span> đã về kho hà nội. Tổng số tiền cần thanh toán là: <span style="color:red">{{number_format($totalMoney)}} VNĐ</span></span>
            @endif
            @endif
        </div>
        
        <div class="box-body" style=" overflow-x: scroll; ">
            <table class="table table-bordered logs-system">
                <thead>
                    <tr>
                        <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Mã Vận đơn') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Khối lượng') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Mã hoá đơn') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Ghi chú') !!}</th>
                        <th>{!! \PaginationHelper::sort('id', 'Trạng thái') !!}</th>
                        <th>{!! \PaginationHelper::sort('created_at', 'Thời gian tạo' ) !!}</th>
                        <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach( $deliveryCodes as $deliveryCode )
                        <tr>
                            <td>{{ $deliveryCode->id }}</td>
                            <td>{{ $deliveryCode->code }}</td>
                            <td>{{ $deliveryCode->weight }}</td>
                            <td>{{ $deliveryCode->order_code }}</td>
                            <td>{{ $deliveryCode->note }}</td>
                            <td>
                                @if ($deliveryCode->status == 1)
                                <span style="color:#DC143C">Đang về</span>
                                @elseif($deliveryCode->status == 2)
                                <span style="color:#FFA500">Đang ở kho Hà Nội</span>
                                @elseif($deliveryCode->status == 3)
                                <span style="color:#483D8B">Khách đã nhận</span>
                                @endif
                            </td>
                            <td>{{ $deliveryCode->created_at }}</td>
                            <td>
                                @if($deliveryCode->status == 1)
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\OrderController@destroyDeliveryCode', $deliveryCode->id) !!}">Xóa</a>
                                @endif
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
