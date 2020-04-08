@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'delivery-codes'] )

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
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $('.customer').select2()
            $('#cover-image').change(function (event) {
                $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
    DeliveryCode | Admin | {{ config('site.name') }}
@stop

@section('header')
    DeliveryCode
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\DeliveryCodeController@index') !!}"><i class="fa fa-files-o"></i> DeliveryCode</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $deliveryCode->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\DeliveryCodeController@store') !!} @else {!! action('Admin\DeliveryCodeController@update', [$deliveryCode->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\DeliveryCodeController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                                                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">Mã vận đơn</label>
                                    <div class="form-control m-input">{{$deliveryCode->code }}</div>
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="weight">Cân nặng</label>
                                    <input type="number" min="0" class="form-control m-input" name="weight" id="weight" placeholder="Cân nặng" value="{{ old('weight') ? old('weight') : $deliveryCode->weight }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="customer_id">Mã khách hàng</label>
                                    <div class="form-control m-input">{{@$deliveryCode->customer->name}} - {{@$deliveryCode->customer->code}}</div>
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1" @if($deliveryCode->status == 1) selected @endif>Chưa nhận hàng</option>
                                        <option value="2" @if($deliveryCode->status == 2) selected @endif>Đã nhận hàng</option>
                                        <option value="3" @if($deliveryCode->status == 3) selected @endif>Đã giao hàng cho khách</option>
                                    </select>
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
