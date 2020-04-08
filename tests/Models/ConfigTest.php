<?php namespace Tests\Models;

use App\Models\Config;
use Tests\TestCase;

class ConfigTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Config $config */
        $config = new Config();
        $this->assertNotNull($config);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Config $config */
        $configModel = new Config();

        $configData = factory(Config::class)->make();
        foreach( $configData->toFillableArray() as $key => $value ) {
            $configModel->$key = $value;
        }
        $configModel->save();

        $this->assertNotNull(Config::find($configModel->id));
    }

}
