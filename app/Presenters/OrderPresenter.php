<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\AdminUser;
use App\Models\Customer;

class OrderPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\AdminUser
    * */
    public function adminUser()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('AdminUserModel');
            $cached = Redis::hget($cacheKey, $this->entity->admin_user_id);

            if( $cached ) {
                $adminUser = new AdminUser(json_decode($cached, true));
                $adminUser['id'] = json_decode($cached, true)['id'];
                return $adminUser;
            } else {
                $adminUser = $this->entity->adminUser;
                Redis::hsetnx($cacheKey, $this->entity->admin_user_id, $adminUser);
                return $adminUser;
            }
        }

        $adminUser = $this->entity->adminUser;
        return $adminUser;
    }

    /**
    * @return \App\Models\Customer
    * */
    public function customer()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('CustomerModel');
            $cached = Redis::hget($cacheKey, $this->entity->customer_id);

            if( $cached ) {
                $customer = new Customer(json_decode($cached, true));
                $customer['id'] = json_decode($cached, true)['id'];
                return $customer;
            } else {
                $customer = $this->entity->customer;
                Redis::hsetnx($cacheKey, $this->entity->customer_id, $customer);
                return $customer;
            }
        }

        $customer = $this->entity->customer;
        return $customer;
    }

    
}
