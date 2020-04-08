<?php namespace Tests\Models;

use App\Models\DeliveryCodesTempt;
use Tests\TestCase;

class DeliveryCodesTemptTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\DeliveryCodesTempt $deliveryCodesTempt */
        $deliveryCodesTempt = new DeliveryCodesTempt();
        $this->assertNotNull($deliveryCodesTempt);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\DeliveryCodesTempt $deliveryCodesTempt */
        $deliveryCodesTemptModel = new DeliveryCodesTempt();

        $deliveryCodesTemptData = factory(DeliveryCodesTempt::class)->make();
        foreach( $deliveryCodesTemptData->toFillableArray() as $key => $value ) {
            $deliveryCodesTemptModel->$key = $value;
        }
        $deliveryCodesTemptModel->save();

        $this->assertNotNull(DeliveryCodesTempt::find($deliveryCodesTemptModel->id));
    }

}
