<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Order;
use App\Models\DeliveryCode;

class OrdersDeliveryPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Order
    * */
    public function order()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('OrderModel');
            $cached = Redis::hget($cacheKey, $this->entity->order_id);

            if( $cached ) {
                $order = new Order(json_decode($cached, true));
                $order['id'] = json_decode($cached, true)['id'];
                return $order;
            } else {
                $order = $this->entity->order;
                Redis::hsetnx($cacheKey, $this->entity->order_id, $order);
                return $order;
            }
        }

        $order = $this->entity->order;
        return $order;
    }

    /**
    * @return \App\Models\DeliveryCode
    * */
    public function deliveryCode()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('DeliveryCodeModel');
            $cached = Redis::hget($cacheKey, $this->entity->delivery_code_id);

            if( $cached ) {
                $deliveryCode = new DeliveryCode(json_decode($cached, true));
                $deliveryCode['id'] = json_decode($cached, true)['id'];
                return $deliveryCode;
            } else {
                $deliveryCode = $this->entity->deliveryCode;
                Redis::hsetnx($cacheKey, $this->entity->delivery_code_id, $deliveryCode);
                return $deliveryCode;
            }
        }

        $deliveryCode = $this->entity->deliveryCode;
        return $deliveryCode;
    }

    
}
