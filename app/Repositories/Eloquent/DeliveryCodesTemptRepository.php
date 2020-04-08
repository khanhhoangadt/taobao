<?php namespace App\Repositories\Eloquent;

use \App\Repositories\DeliveryCodesTemptRepositoryInterface;
use \App\Models\DeliveryCodesTempt;

class DeliveryCodesTemptRepository extends SingleKeyModelRepository implements DeliveryCodesTemptRepositoryInterface
{

    public function getBlankModel()
    {
        return new DeliveryCodesTempt();
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
