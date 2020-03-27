<?php namespace App\Repositories\Eloquent;

use \App\Repositories\PriceRepositoryInterface;
use \App\Models\Price;

class PriceRepository extends SingleKeyModelRepository implements PriceRepositoryInterface
{

    public function getBlankModel()
    {
        return new Price();
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
