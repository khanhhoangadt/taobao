@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'orders'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
    </script>
@stop

@section('title')
    Mã vận đơn | Admin | {{ config('site.name') }}
@stop

@section('header')
    Mã vận đơn
@stop

@section('breadcrumb')
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

    <form action="{!! action('Admin\OrderController@saveDeliveryCode') !!}" method="POST">
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\OrderController@listDeliveryCode', $orderId) !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="code">Mã vận đơn</label>
                            <input type="text" class="form-control m-input" name="delivery_code" id="code" required placeholder="Mã hoá đơn">
                            <input type="hidden" value="{{$orderId}}" name="order_id">
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
