<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class OrderControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\OrderController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\OrderController::class);
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
        $response = $this->action('GET', 'Admin\OrderController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\OrderController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $order = factory(\App\Models\Order::class)->make();
        $this->action('POST', 'Admin\OrderController@store', [
                '_token' => csrf_token(),
            ] + $order->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $order = factory(\App\Models\Order::class)->create();
        $this->action('GET', 'Admin\OrderController@show', [$order->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $order = factory(\App\Models\Order::class)->create();

        $name = $faker->name;
        $id = $order->id;

        $order->name = $name;

        $this->action('PUT', 'Admin\OrderController@update', [$id], [
                '_token' => csrf_token(),
            ] + $order->toArray());
        $this->assertResponseStatus(302);

        $newOrder = \App\Models\Order::find($id);
        $this->assertEquals($name, $newOrder->name);
    }

    public function testDeleteModel()
    {
        $order = factory(\App\Models\Order::class)->create();

        $id = $order->id;

        $this->action('DELETE', 'Admin\OrderController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkOrder = \App\Models\Order::find($id);
        $this->assertNull($checkOrder);
    }

}
