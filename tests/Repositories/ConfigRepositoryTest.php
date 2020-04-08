<?php namespace Tests\Repositories;

use App\Models\Config;
use Tests\TestCase;

class ConfigRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $configs = factory(Config::class, 3)->create();
        $configIds = $configs->pluck('id')->toArray();

        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);

        $configsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Config::class, $configsCheck[0]);

        $configsCheck = $repository->getByIds($configIds);
        $this->assertEquals(3, count($configsCheck));
    }

    public function testFind()
    {
        $configs = factory(Config::class, 3)->create();
        $configIds = $configs->pluck('id')->toArray();

        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);

        $configCheck = $repository->find($configIds[0]);
        $this->assertEquals($configIds[0], $configCheck->id);
    }

    public function testCreate()
    {
        $configData = factory(Config::class)->make();

        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);

        $configCheck = $repository->create($configData->toFillableArray());
        $this->assertNotNull($configCheck);
    }

    public function testUpdate()
    {
        $configData = factory(Config::class)->create();

        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);

        $configCheck = $repository->update($configData, $configData->toFillableArray());
        $this->assertNotNull($configCheck);
    }

    public function testDelete()
    {
        $configData = factory(Config::class)->create();

        /** @var  \App\Repositories\ConfigRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ConfigRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($configData);

        $configCheck = $repository->find($configData->id);
        $this->assertNull($configCheck);
    }

}
