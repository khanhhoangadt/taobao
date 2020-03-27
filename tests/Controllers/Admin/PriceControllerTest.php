<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class PriceControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\PriceController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\PriceController::class);
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
        $response = $this->action('GET', 'Admin\PriceController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\PriceController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $price = factory(\App\Models\Price::class)->make();
        $this->action('POST', 'Admin\PriceController@store', [
                '_token' => csrf_token(),
            ] + $price->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $price = factory(\App\Models\Price::class)->create();
        $this->action('GET', 'Admin\PriceController@show', [$price->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $price = factory(\App\Models\Price::class)->create();

        $name = $faker->name;
        $id = $price->id;

        $price->name = $name;

        $this->action('PUT', 'Admin\PriceController@update', [$id], [
                '_token' => csrf_token(),
            ] + $price->toArray());
        $this->assertResponseStatus(302);

        $newPrice = \App\Models\Price::find($id);
        $this->assertEquals($name, $newPrice->name);
    }

    public function testDeleteModel()
    {
        $price = factory(\App\Models\Price::class)->create();

        $id = $price->id;

        $this->action('DELETE', 'Admin\PriceController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkPrice = \App\Models\Price::find($id);
        $this->assertNull($checkPrice);
    }

}
