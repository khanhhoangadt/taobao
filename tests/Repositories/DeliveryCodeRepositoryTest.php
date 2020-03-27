<?php namespace Tests\Repositories;

use App\Models\DeliveryCode;
use Tests\TestCase;

class DeliveryCodeRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $deliveryCodes = factory(DeliveryCode::class, 3)->create();
        $deliveryCodeIds = $deliveryCodes->pluck('id')->toArray();

        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(DeliveryCode::class, $deliveryCodesCheck[0]);

        $deliveryCodesCheck = $repository->getByIds($deliveryCodeIds);
        $this->assertEquals(3, count($deliveryCodesCheck));
    }

    public function testFind()
    {
        $deliveryCodes = factory(DeliveryCode::class, 3)->create();
        $deliveryCodeIds = $deliveryCodes->pluck('id')->toArray();

        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodeCheck = $repository->find($deliveryCodeIds[0]);
        $this->assertEquals($deliveryCodeIds[0], $deliveryCodeCheck->id);
    }

    public function testCreate()
    {
        $deliveryCodeData = factory(DeliveryCode::class)->make();

        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodeCheck = $repository->create($deliveryCodeData->toFillableArray());
        $this->assertNotNull($deliveryCodeCheck);
    }

    public function testUpdate()
    {
        $deliveryCodeData = factory(DeliveryCode::class)->create();

        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodeCheck = $repository->update($deliveryCodeData, $deliveryCodeData->toFillableArray());
        $this->assertNotNull($deliveryCodeCheck);
    }

    public function testDelete()
    {
        $deliveryCodeData = factory(DeliveryCode::class)->create();

        /** @var  \App\Repositories\DeliveryCodeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($deliveryCodeData);

        $deliveryCodeCheck = $repository->find($deliveryCodeData->id);
        $this->assertNull($deliveryCodeCheck);
    }

}
