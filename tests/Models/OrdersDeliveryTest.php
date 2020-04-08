<?php namespace Tests\Models;

use App\Models\OrdersDelivery;
use Tests\TestCase;

class OrdersDeliveryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\OrdersDelivery $ordersDelivery */
        $ordersDelivery = new OrdersDelivery();
        $this->assertNotNull($ordersDelivery);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\OrdersDelivery $ordersDelivery */
        $ordersDeliveryModel = new OrdersDelivery();

        $ordersDeliveryData = factory(OrdersDelivery::class)->make();
        foreach( $ordersDeliveryData->toFillableArray() as $key => $value ) {
            $ordersDeliveryModel->$key = $value;
        }
        $ordersDeliveryModel->save();

        $this->assertNotNull(OrdersDelivery::find($ordersDeliveryModel->id));
    }

}
