<?php namespace Tests\Models;

use App\Models\OderDelivery;
use Tests\TestCase;

class OderDeliveryTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\OderDelivery $oderDelivery */
        $oderDelivery = new OderDelivery();
        $this->assertNotNull($oderDelivery);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\OderDelivery $oderDelivery */
        $oderDeliveryModel = new OderDelivery();

        $oderDeliveryData = factory(OderDelivery::class)->make();
        foreach( $oderDeliveryData->toFillableArray() as $key => $value ) {
            $oderDeliveryModel->$key = $value;
        }
        $oderDeliveryModel->save();

        $this->assertNotNull(OderDelivery::find($oderDeliveryModel->id));
    }

}
