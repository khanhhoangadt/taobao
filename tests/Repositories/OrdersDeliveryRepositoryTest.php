<?php namespace Tests\Repositories;

use App\Models\OrdersDelivery;
use Tests\TestCase;

class OrdersDeliveryRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $ordersDeliveries = factory(OrdersDelivery::class, 3)->create();
        $ordersDeliveryIds = $ordersDeliveries->pluck('id')->toArray();

        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $ordersDeliveriesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(OrdersDelivery::class, $ordersDeliveriesCheck[0]);

        $ordersDeliveriesCheck = $repository->getByIds($ordersDeliveryIds);
        $this->assertEquals(3, count($ordersDeliveriesCheck));
    }

    public function testFind()
    {
        $ordersDeliveries = factory(OrdersDelivery::class, 3)->create();
        $ordersDeliveryIds = $ordersDeliveries->pluck('id')->toArray();

        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $ordersDeliveryCheck = $repository->find($ordersDeliveryIds[0]);
        $this->assertEquals($ordersDeliveryIds[0], $ordersDeliveryCheck->id);
    }

    public function testCreate()
    {
        $ordersDeliveryData = factory(OrdersDelivery::class)->make();

        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $ordersDeliveryCheck = $repository->create($ordersDeliveryData->toFillableArray());
        $this->assertNotNull($ordersDeliveryCheck);
    }

    public function testUpdate()
    {
        $ordersDeliveryData = factory(OrdersDelivery::class)->create();

        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $ordersDeliveryCheck = $repository->update($ordersDeliveryData, $ordersDeliveryData->toFillableArray());
        $this->assertNotNull($ordersDeliveryCheck);
    }

    public function testDelete()
    {
        $ordersDeliveryData = factory(OrdersDelivery::class)->create();

        /** @var  \App\Repositories\OrdersDeliveryRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OrdersDeliveryRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($ordersDeliveryData);

        $ordersDeliveryCheck = $repository->find($ordersDeliveryData->id);
        $this->assertNull($ordersDeliveryCheck);
    }

}
