<?php

namespace App\Shop\PaymentMethods\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\PaymentMethods\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepositoryInterface extends BaseRepositoryInterface
{
    public function createPaymentMethod(array $data) : PaymentMethod;

    public function updatePaymentMethod(array $update) : PaymentMethod;

    public function findPaymentMethodById(int $id) : PaymentMethod;

    public function listPaymentMethods(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function getClientId() : string;

    public function getClientSecret() : string;
}