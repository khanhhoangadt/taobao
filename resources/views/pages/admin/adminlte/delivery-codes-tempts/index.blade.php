@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'delivery_codes_tempts'] )

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
    DeliveryCodesTempt | Admin | {{ config('site.name') }}
@stop

@section('breadcrumb')
    <li class="active">DeliveryCodesTempt</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-md-7">
                    <form method="get" accept-charset="utf-8" action="{!! action('Admin\DeliveryCodesTemptController@index') !!}">
                        {!! csrf_field() !!}
                        <div class="row search-input">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <div class="search-input-text">
                                    <input type="text" name="keyword" class="form-control" placeholder="Search here" id="keyword" value="{{ $keyword }}">
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
                                                                                <th>{!! \PaginationHelper::sort('name', trans('admin.pages.delivery-codes-tempts.columns.name')) !!}</th>
                                                                                <th>{!! \PaginationHelper::sort('code', trans('admin.pages.delivery-codes-tempts.columns.code')) !!}</th>
                        
                      
                    </tr>
                </thead>

                <tbody>
                    @foreach( $deliveryCodesTempts as $deliveryCodesTempt )
                        <tr>
                            <td>{{ $deliveryCodesTempt->id }}</td>
                                                                                            <td>{{ $deliveryCodesTempt->name }}</td>
                                                                                            <td>{{ $deliveryCodesTempt->code }}</td>
                                                        
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