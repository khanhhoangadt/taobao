<?php namespace App\Repositories\Eloquent;

use \App\Repositories\OrdersDeliveryRepositoryInterface;
use \App\Models\OrdersDelivery;

class OrdersDeliveryRepository extends SingleKeyModelRepository implements OrdersDeliveryRepositoryInterface
{

    public function getBlankModel()
    {
        return new OrdersDelivery();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
