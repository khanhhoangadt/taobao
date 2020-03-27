<?php namespace Tests\Repositories;

use App\Models\Price;
use Tests\TestCase;

class PriceRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $prices = factory(Price::class, 3)->create();
        $priceIds = $prices->pluck('id')->toArray();

        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $pricesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Price::class, $pricesCheck[0]);

        $pricesCheck = $repository->getByIds($priceIds);
        $this->assertEquals(3, count($pricesCheck));
    }

    public function testFind()
    {
        $prices = factory(Price::class, 3)->create();
        $priceIds = $prices->pluck('id')->toArray();

        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $priceCheck = $repository->find($priceIds[0]);
        $this->assertEquals($priceIds[0], $priceCheck->id);
    }

    public function testCreate()
    {
        $priceData = factory(Price::class)->make();

        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $priceCheck = $repository->create($priceData->toFillableArray());
        $this->assertNotNull($priceCheck);
    }

    public function testUpdate()
    {
        $priceData = factory(Price::class)->create();

        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $priceCheck = $repository->update($priceData, $priceData->toFillableArray());
        $this->assertNotNull($priceCheck);
    }

    public function testDelete()
    {
        $priceData = factory(Price::class)->create();

        /** @var  \App\Repositories\PriceRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PriceRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($priceData);

        $priceCheck = $repository->find($priceData->id);
        $this->assertNull($priceCheck);
    }

}
