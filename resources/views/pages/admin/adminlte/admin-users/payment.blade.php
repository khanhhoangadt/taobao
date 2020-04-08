@extends('pages.admin.' . config('view.admin') . '.layout.application', ['menu' => 'admin_users'] )

@section('metadata')
@stop

@section('styles')
    <style>
        .button-checkbox button {
            padding: 3px 20px;
        }
        a {
            color: inherit; /* blue colors for links too */
            text-decoration: inherit; /* no underline */
        }
    </style>
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('js/jquery_checkbox_btn.js', 'admin/adminlte') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});

        $(document).ready(function () {
            $('#profile-image').change(function (event) {
                $('#profile-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    AdminUsers
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
    <form action="{!! action('Admin\AdminUserController@payment') !!}" method="GET">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="config">Mã khách hàng</label>
                        <input type="text" name="code" class="form-control" value="{{isset($code) ? $code : ""}}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">Tìm kiếm</button>
            </div>
        </div>
    </form>
    @if (isset($customer))
    <table class="table table-bordered">
        <tr>
            <th>Mã khách hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
        </tr>
        <tr>
            <td>{{ $customer->code }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{$customer->address}}</td>
        </tr>
    </table>
    @endif
    @if (isset($deliveryCodes))
    <table class="table table-bordered">
        <tr>
            <th>Mã vận đơn</th>
            <th>Cân nặng (KG)</th>
        </tr>
        @if(!count($deliveryCodes))
            <tr>
                <td colspan="2">
                <span style="color:red">Không có mã vận đơn nào có thể thanh toán</span>
                </td>
            </tr>
        @else
            @foreach($deliveryCodes as $deliveryCode)
            <tr>
                <td>{{ $deliveryCode->code }}</td>
                <td>{{ $deliveryCode->weight }}</td>
            </tr>
            @endforeach
        @endif  
    </table>
    @endif
    @if (isset($money))
    Tổng tiền cần thanh toán là: <span style="color:red">{{number_format($money)}} </span>VNĐ
    @endif
    <br/>
    @if (isset($customer) && isset($deliveryCodes) && count($deliveryCodes))
    <button style="margin-top:30px; background:green; color:white">
    <a href="{!! action('Admin\AdminUserController@updateStatusAfterPayment', $customer->id) !!}" onclick="return confirm('Bạn không thể hoàn tác hành động này. Có muốn tiếp tục?')">Thanh Toán</a>
    </button>
    @endif
@stop
