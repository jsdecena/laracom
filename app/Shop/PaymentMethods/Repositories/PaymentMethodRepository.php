<?php

namespace App\Shop\PaymentMethods\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\PaymentMethods\Exceptions\CreatePaymentMethodException;
use App\Shop\PaymentMethods\Exceptions\UpdatePaymentErrorException;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
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
        $this->model = $paymentMethod;
    }

    /**
     * Create the payment method
     *
     * @param array $data
     * @return PaymentMethod
     * @throws CreatePaymentMethodException
     */
    public function createPaymentMethod(array $data) : PaymentMethod
    {
        $data['slug'] = str_slug($data['name']);

        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreatePaymentMethodException($e);
        }
    }

    /**
     * Update the payment method
     *
     * @param array $data
     * @return PaymentMethod
     * @throws UpdatePaymentErrorException
     */
    public function updatePaymentMethod(array $data) : PaymentMethod
    {
        $data['slug'] = str_slug($data['name']);

        try {
            $this->update($data, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new UpdatePaymentErrorException($e->getMessage());
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
        return $this->all($columns, $order, $sort)->where('status', 1);
    }

    /**
     * @return Collection
     */
    public function findOrders() : Collection
    {
        return $this->model->orders()->get();
    }
}
