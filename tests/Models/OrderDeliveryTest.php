<?php namespace Tests\Models;

use App\Models\OrderDelivery;
use Tests\TestCase;

class OrderDeliveryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\OrderDelivery $orderDelivery */
        $orderDelivery = new OrderDelivery();
        $this->assertNotNull($orderDelivery);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\OrderDelivery $orderDelivery */
        $orderDeliveryModel = new OrderDelivery();

        $orderDeliveryData = factory(OrderDelivery::class)->make();
        foreach( $orderDeliveryData->toFillableArray() as $key => $value ) {
            $orderDeliveryModel->$key = $value;
        }
        $orderDeliveryModel->save();

        $this->assertNotNull(OrderDelivery::find($orderDeliveryModel->id));
    }

}
