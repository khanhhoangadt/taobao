<?php

namespace App\Repositories;

interface AdminUserRepositoryInterface extends AuthenticatableRepositoryInterface
{
    public function allByRole($role);
    public function getMonney($customerId, $arrWeight);
}
