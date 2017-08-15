<?php

namespace App\PaymentMethods\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\PaymentMethods\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepositoryInterface extends BaseRepositoryInterface
{
    public function createPaymentMethod(array $data) : PaymentMethod;

    public function updatePaymentMethod(array $update) : PaymentMethod;

    public function findPaymentMethodById(int $id) : PaymentMethod;

    public function listPaymentMethods(string $order = 'id', string $sort = 'desc') : Collection;

    public function getClientId() : string;

    public function getClientSecret() : string;
}