@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'delivery-codes-tempts'] )

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
    DeliveryCodesTempt | Admin | {{ config('site.name') }}
@stop

@section('header')
    DeliveryCodesTempt
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\DeliveryCodesTemptController@index') !!}"><i class="fa fa-files-o"></i> DeliveryCodesTempt</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $deliveryCodesTempt->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\DeliveryCodesTemptController@store') !!} @else {!! action('Admin\DeliveryCodesTemptController@update', [$deliveryCodesTempt->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\DeliveryCodesTemptController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">
                        @lang('admin.pages.common.buttons.back')
                    </a>
                </h3>
            </div>

            <div class="box-body">
                                                            <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('admin.pages.delivery-codes-tempts.columns.name')</label>
                                    <input type="text" class="form-control m-input" name="name" id="name" required placeholder="@lang('admin.pages.delivery-codes-tempts.columns.name')" value="{{ old('name') ? old('name') : $deliveryCodesTempt->name }}">
                                </div>
                            </div>
                        </div>
                                                                                <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="code">@lang('admin.pages.delivery-codes-tempts.columns.code')</label>
                                    <input type="text" class="form-control m-input" name="code" id="code" required placeholder="@lang('admin.pages.delivery-codes-tempts.columns.code')" value="{{ old('code') ? old('code') : $deliveryCodesTempt->code }}">
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
