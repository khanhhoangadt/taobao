<?php

namespace App\Repositories\Eloquent;

use App\Repositories\AdminUserRepositoryInterface;
use App\Models\AdminUser;
use App\Models\AdminUserRole;
use App\Models\Price;
use App\Models\Config;

class AdminUserRepository extends AuthenticatableRepository implements AdminUserRepositoryInterface
{
    protected $querySearchTargets = ['name', 'email'];

    public function getBlankModel()
    {
        return new AdminUser();
    }

    public function getPriceModel()
    {
        return new Price();
    }

    public function getConfigModel()
    {
        return new Config();
    }

    public function allByRole($role)
    { 
        return $this->getBlankModel()->whereHas('roles', function($query) use ($role) {
            $query->where('role', $role);
        })->select('name', 'id', 'code')->get();
    }

    public function getMonney($customerId, $arrWeight)
    {
        $priceDefault = $this->getConfigModel()->first();
        $totalWeight = array_sum($arrWeight);
        $prices = $this->getPriceModel()->where('customer_id', $customerId)->orderBy('qty', 'desc')->get();
        
        if (!count($prices)) {
            return $totalWeight * $priceDefault['value'];
        }

        foreach($prices as $price) {
            if ($totalWeight >= $price->qty) return $totalWeight * $price->price;
        }
    }
}
