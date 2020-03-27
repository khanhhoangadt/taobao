<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Customer;

class DeliveryCodePresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

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
