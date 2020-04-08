<?php namespace Tests\Repositories;

use App\Models\DeliveryCodesTempt;
use Tests\TestCase;

class DeliveryCodesTemptRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $deliveryCodesTempts = factory(DeliveryCodesTempt::class, 3)->create();
        $deliveryCodesTemptIds = $deliveryCodesTempts->pluck('id')->toArray();

        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodesTemptsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(DeliveryCodesTempt::class, $deliveryCodesTemptsCheck[0]);

        $deliveryCodesTemptsCheck = $repository->getByIds($deliveryCodesTemptIds);
        $this->assertEquals(3, count($deliveryCodesTemptsCheck));
    }

    public function testFind()
    {
        $deliveryCodesTempts = factory(DeliveryCodesTempt::class, 3)->create();
        $deliveryCodesTemptIds = $deliveryCodesTempts->pluck('id')->toArray();

        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodesTemptCheck = $repository->find($deliveryCodesTemptIds[0]);
        $this->assertEquals($deliveryCodesTemptIds[0], $deliveryCodesTemptCheck->id);
    }

    public function testCreate()
    {
        $deliveryCodesTemptData = factory(DeliveryCodesTempt::class)->make();

        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodesTemptCheck = $repository->create($deliveryCodesTemptData->toFillableArray());
        $this->assertNotNull($deliveryCodesTemptCheck);
    }

    public function testUpdate()
    {
        $deliveryCodesTemptData = factory(DeliveryCodesTempt::class)->create();

        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);

        $deliveryCodesTemptCheck = $repository->update($deliveryCodesTemptData, $deliveryCodesTemptData->toFillableArray());
        $this->assertNotNull($deliveryCodesTemptCheck);
    }

    public function testDelete()
    {
        $deliveryCodesTemptData = factory(DeliveryCodesTempt::class)->create();

        /** @var  \App\Repositories\DeliveryCodesTemptRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeliveryCodesTemptRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($deliveryCodesTemptData);

        $deliveryCodesTemptCheck = $repository->find($deliveryCodesTemptData->id);
        $this->assertNull($deliveryCodesTemptCheck);
    }

}
