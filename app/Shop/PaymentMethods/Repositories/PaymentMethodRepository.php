<?php

namespace App\Shop\PaymentMethods\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodInvalidArgumentException;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    /**
     * PaymentMethodRepository constructor.
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod)
    {
        parent::__construct($paymentMethod);
    }

    /**
     * Create the payment method
     *
     * @param array $data
     * @return PaymentMethod
     * @throws PaymentMethodInvalidArgumentException
     */
    public function createPaymentMethod(array $data) : PaymentMethod
    {
        $collection = collect($data)->merge(['slug' => str_slug($data['name'])]);

        try {
            return $this->create($collection->all());
        } catch (QueryException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        } catch (ErrorException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the payment method
     *
     * @param array $update
     * @return PaymentMethod
     * @throws PaymentMethodInvalidArgumentException
     */
    public function updatePaymentMethod(array $update) : PaymentMethod
    {
        $collection = collect($update)->merge(['slug' => str_slug($update['name'])]);

        try {
            $this->update($collection->all(), $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Find the payment method
     *
     * @param int $id
     * @return PaymentMethod
     * @throws PaymentMethodNotFoundException
     */
    public function findPaymentMethodById(int $id) : PaymentMethod
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PaymentMethodNotFoundException($e->getMessage());
        }
    }

    /**
     * Return all the payment methods
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection|mixed
     */
    public function listPaymentMethods(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Returns the client ID
     *
     * @return string
     */
    public function getClientId() : string
    {
        return $this->model->getClientId();
    }

    /**
     * Returns the client secret
     *
     * @return string
     */
    public function getClientSecret() : string
    {
        return $this->model->getClientSecret();
    }
}
