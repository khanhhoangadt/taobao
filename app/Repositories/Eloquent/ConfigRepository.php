<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ConfigRepositoryInterface;
use \App\Models\Config;

class ConfigRepository extends SingleKeyModelRepository implements ConfigRepositoryInterface
{

    public function getBlankModel()
    {
        return new Config();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
