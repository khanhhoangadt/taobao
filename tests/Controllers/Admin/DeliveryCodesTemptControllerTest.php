<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class DeliveryCodesTemptControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\DeliveryCodesTemptController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\DeliveryCodesTemptController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = \App\Models\AdminUser::first();
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\DeliveryCodesTemptController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\DeliveryCodesTemptController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $deliveryCodesTempt = factory(\App\Models\DeliveryCodesTempt::class)->make();
        $this->action('POST', 'Admin\DeliveryCodesTemptController@store', [
                '_token' => csrf_token(),
            ] + $deliveryCodesTempt->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $deliveryCodesTempt = factory(\App\Models\DeliveryCodesTempt::class)->create();
        $this->action('GET', 'Admin\DeliveryCodesTemptController@show', [$deliveryCodesTempt->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $deliveryCodesTempt = factory(\App\Models\DeliveryCodesTempt::class)->create();

        $name = $faker->name;
        $id = $deliveryCodesTempt->id;

        $deliveryCodesTempt->name = $name;

        $this->action('PUT', 'Admin\DeliveryCodesTemptController@update', [$id], [
                '_token' => csrf_token(),
            ] + $deliveryCodesTempt->toArray());
        $this->assertResponseStatus(302);

        $newDeliveryCodesTempt = \App\Models\DeliveryCodesTempt::find($id);
        $this->assertEquals($name, $newDeliveryCodesTempt->name);
    }

    public function testDeleteModel()
    {
        $deliveryCodesTempt = factory(\App\Models\DeliveryCodesTempt::class)->create();

        $id = $deliveryCodesTempt->id;

        $this->action('DELETE', 'Admin\DeliveryCodesTemptController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkDeliveryCodesTempt = \App\Models\DeliveryCodesTempt::find($id);
        $this->assertNull($checkDeliveryCodesTempt);
    }

}
