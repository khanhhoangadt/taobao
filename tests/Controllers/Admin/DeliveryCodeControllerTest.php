<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class DeliveryCodeControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\DeliveryCodeController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\DeliveryCodeController::class);
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
        $response = $this->action('GET', 'Admin\DeliveryCodeController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\DeliveryCodeController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $deliveryCode = factory(\App\Models\DeliveryCode::class)->make();
        $this->action('POST', 'Admin\DeliveryCodeController@store', [
                '_token' => csrf_token(),
            ] + $deliveryCode->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $deliveryCode = factory(\App\Models\DeliveryCode::class)->create();
        $this->action('GET', 'Admin\DeliveryCodeController@show', [$deliveryCode->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $deliveryCode = factory(\App\Models\DeliveryCode::class)->create();

        $name = $faker->name;
        $id = $deliveryCode->id;

        $deliveryCode->name = $name;

        $this->action('PUT', 'Admin\DeliveryCodeController@update', [$id], [
                '_token' => csrf_token(),
            ] + $deliveryCode->toArray());
        $this->assertResponseStatus(302);

        $newDeliveryCode = \App\Models\DeliveryCode::find($id);
        $this->assertEquals($name, $newDeliveryCode->name);
    }

    public function testDeleteModel()
    {
        $deliveryCode = factory(\App\Models\DeliveryCode::class)->create();

        $id = $deliveryCode->id;

        $this->action('DELETE', 'Admin\DeliveryCodeController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkDeliveryCode = \App\Models\DeliveryCode::find($id);
        $this->assertNull($checkDeliveryCode);
    }

}
