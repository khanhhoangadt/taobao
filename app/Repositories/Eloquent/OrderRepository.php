<?php namespace App\Repositories\Eloquent;

use \App\Repositories\OrderRepositoryInterface;
use \App\Models\Order;

class OrderRepository extends SingleKeyModelRepository implements OrderRepositoryInterface
{

    public function getBlankModel()
    {
        return new Order();
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
