<?php namespace Tests\Models;

use App\Models\DeliveryCode;
use Tests\TestCase;

class DeliveryCodeTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\DeliveryCode $deliveryCode */
        $deliveryCode = new DeliveryCode();
        $this->assertNotNull($deliveryCode);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\DeliveryCode $deliveryCode */
        $deliveryCodeModel = new DeliveryCode();

        $deliveryCodeData = factory(DeliveryCode::class)->make();
        foreach( $deliveryCodeData->toFillableArray() as $key => $value ) {
            $deliveryCodeModel->$key = $value;
        }
        $deliveryCodeModel->save();

        $this->assertNotNull(DeliveryCode::find($deliveryCodeModel->id));
    }

}
