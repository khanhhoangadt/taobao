<?php

\Route::group(['middleware' => ['admin.values']], function () {

    \Route::group(['middleware' => ['admin.guest']], function () {
        \Route::get('signin', 'Admin\AuthController@getSignIn');
        \Route::post('signin', 'Admin\AuthController@postSignIn');
        \Route::get('forgot-password', 'Admin\PasswordController@getForgotPassword');
        \Route::post('forgot-password', 'Admin\PasswordController@postForgotPassword');
        \Route::get('reset-password/{token}', 'Admin\PasswordController@getResetPassword');
        \Route::post('reset-password', 'Admin\PasswordController@postResetPassword');
    });

    \Route::group(['middleware' => ['admin.auth']], function () {

        \Route::group(['middleware' => ['admin.has_role.super_user']], function () {
            \Route::resource('users', 'Admin\UserController');
            \Route::resource('user-notifications', 'Admin\UserNotificationController');

            \Route::post('articles/preview', 'Admin\ArticleController@preview');
            \Route::get('articles/images', 'Admin\ArticleController@getImages');
            \Route::post('articles/images', 'Admin\ArticleController@postImage');
            \Route::delete('articles/images', 'Admin\ArticleController@deleteImage');
            \Route::resource('articles', 'Admin\ArticleController');

            \Route::delete('images/delete', 'Admin\ImageController@deleteByUrl');
            \Route::resource('images', 'Admin\ImageController');

            \Route::resource('oauth-clients', 'Admin\OauthClientController');
            \Route::resource('logs', 'Admin\LogController');
            \Route::resource('prices', 'Admin\PriceController');

        });

        \Route::group(['middleware' => ['admin.has_role.admin']], function () {
            \Route::resource('admin-users', 'Admin\AdminUserController');
            \Route::resource('admin-user-notifications', 'Admin\AdminUserNotificationController');
            
            \Route::get('load-notification/{offset}', 'Admin\AdminUserNotificationController@loadNotification');

            \Route::resource('delivery-codes', 'Admin\DeliveryCodeController');
            \Route::post('import-delivery-codes', 'Admin\DeliveryCodeController@import');

            \Route::get('customer-payments', 'Admin\AdminUserController@payment');
            \Route::get('customer-update-after-payments/{customer_id}', 'Admin\AdminUserController@updateStatusAfterPayment');
            \Route::get('customer-config', 'Admin\AdminUserController@config');
            \Route::post('customer-store-config', 'Admin\AdminUserController@storeConfig');
        });

        \Route::get('/', 'Admin\IndexController@index');

        \Route::get('/me', 'Admin\MeController@index');
        \Route::put('/me', 'Admin\MeController@update');
        \Route::get('/me/notifications', 'Admin\MeController@notifications');

        \Route::post('signout', 'Admin\AuthController@postSignOut');

        \Route::resource('orders', 'Admin\OrderController');
        \Route::get('orders-delivery-code/{order_id}', 'Admin\OrderController@listDeliveryCode');
        \Route::get('create-orders-delivery-code/{order_id}', 'Admin\OrderController@createDeliveryCode');
        \Route::post('save-orders-delivery-code', 'Admin\OrderController@saveDeliveryCode');
        \Route::delete('delete-orders-delivery-code/{delivery_code_id}', 'Admin\OrderController@destroyDeliveryCode');

        \Route::resource('orders-deliveries', 'Admin\OrdersDeliveryController');
        \Route::resource('delivery-codes-tempts', 'Admin\DeliveryCodesTemptController');
        /* NEW ADMIN RESOURCE ROUTE */

    });
});
