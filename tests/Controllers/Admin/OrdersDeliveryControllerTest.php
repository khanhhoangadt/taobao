<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class OrdersDeliveryControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\OrdersDeliveryController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\OrdersDeliveryController::class);
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
        $response = $this->action('GET', 'Admin\OrdersDeliveryController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\OrdersDeliveryController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $ordersDelivery = factory(\App\Models\OrdersDelivery::class)->make();
        $this->action('POST', 'Admin\OrdersDeliveryController@store', [
                '_token' => csrf_token(),
            ] + $ordersDelivery->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $ordersDelivery = factory(\App\Models\OrdersDelivery::class)->create();
        $this->action('GET', 'Admin\OrdersDeliveryController@show', [$ordersDelivery->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $ordersDelivery = factory(\App\Models\OrdersDelivery::class)->create();

        $name = $faker->name;
        $id = $ordersDelivery->id;

        $ordersDelivery->name = $name;

        $this->action('PUT', 'Admin\OrdersDeliveryController@update', [$id], [
                '_token' => csrf_token(),
            ] + $ordersDelivery->toArray());
        $this->assertResponseStatus(302);

        $newOrdersDelivery = \App\Models\OrdersDelivery::find($id);
        $this->assertEquals($name, $newOrdersDelivery->name);
    }

    public function testDeleteModel()
    {
        $ordersDelivery = factory(\App\Models\OrdersDelivery::class)->create();

        $id = $ordersDelivery->id;

        $this->action('DELETE', 'Admin\OrdersDeliveryController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkOrdersDelivery = \App\Models\OrdersDelivery::find($id);
        $this->assertNull($checkOrdersDelivery);
    }

}
