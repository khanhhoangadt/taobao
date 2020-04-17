<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if(!empty($authUser->present()->profileImage())) {{ $authUser->present()->profileImage()->present()->url }} @else {!! \URLHelper::asset('img/user_avatar.png', 'common') !!} @endif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>@if($authUser->name){{ $authUser->name }} @else {{ $authUser->email }} @endif</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_ADMIN) )
                
                @endif

            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_SUPER_USER) )
                {{-- <li @if( $menu=='dashboard') class="active" @endif ><a href="{!! \URL::action('Admin\IndexController@index') !!}"><i class="fa fa-dashboard"></i> <span>@lang('admin.menu.dashboard')</span></a></li> --}}

                <li class="header">Users Management</li>
                <li @if( $menu=='admin_users') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserController@index') !!}"><i class="fa fa-user-secret"></i> <span>@lang('admin.menu.admin_users')</span></a></li>
                <li @if( $menu=='prices') class="active" @endif ><a href="{!! \URL::action('Admin\PriceController@index') !!}"><i class="fa fa-money"></i> <span> Bảng giá </span></a></li>
                <li @if( $menu=='configs') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserController@config') !!}"><i class="fa fa-cogs"></i> <span>Thiết lập giá mặc định</span></a></li>
            @endif
            @if( $authUser->hasRole(\App\Models\AdminUserRole::ROLE_ADMIN) )
            <li @if( $menu=='articles') class="active" @endif ><a href="{!! \URL::action('Admin\ArticleController@index') !!}"><i class="fa fa-file-word-o"></i> <span>Viết bài</span></a></li>
            <li @if( $menu=='delivery_codes') class="active" @endif ><a href="{!! \URL::action('Admin\DeliveryCodeController@index') !!}"><i class="fa fa-file-code-o"></i> <span> Mã vận đơn</span></a></li>
            <li @if( $menu=='payment') class="active" @endif ><a href="{!! \URL::action('Admin\AdminUserController@payment') !!}"><i class="fa fa-calculator"></i> <span>Thanh Toán</span></a></li>
            <li @if( $menu=='delivery_codes_tempts') class="active" @endif ><a href="{!! \URL::action('Admin\DeliveryCodesTemptController@index') !!}"><i class="fa fa-users"></i> <span>MVĐ không thuộc hệ thống</span></a></li>
            @endif
            @if($authUser->hasRole(\App\Models\AdminUserRole::ROLE_CUSTOMER, false))
            <li @if( $menu=='orders') class="active" @endif ><a href="{!! \URL::action('Admin\OrderController@listDeliveryCode') !!}"><i class="fa fa-users"></i> <span>Mã vận đơn</span></a></li>
            @endif
            <!-- %%SIDEMENU%% -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
