<?php namespace Tests\Models;

use App\Models\Price;
use Tests\TestCase;

class PriceTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Price $price */
        $price = new Price();
        $this->assertNotNull($price);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Price $price */
        $priceModel = new Price();

        $priceData = factory(Price::class)->make();
        foreach( $priceData->toFillableArray() as $key => $value ) {
            $priceModel->$key = $value;
        }
        $priceModel->save();

        $this->assertNotNull(Price::find($priceModel->id));
    }

}
