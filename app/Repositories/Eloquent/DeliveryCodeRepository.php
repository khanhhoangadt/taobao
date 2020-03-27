<?php namespace App\Repositories\Eloquent;

use \App\Repositories\DeliveryCodeRepositoryInterface;
use \App\Models\DeliveryCode;

class DeliveryCodeRepository extends SingleKeyModelRepository implements DeliveryCodeRepositoryInterface
{

    public function getBlankModel()
    {
        return new DeliveryCode();
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
