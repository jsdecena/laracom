<?php

namespace Laracommerce\Core\Couriers\Repositories;

use Laracommerce\Core\Base\BaseRepository;
use Laracommerce\Core\Countries\Exceptions\CountryNotFoundException;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\Couriers\Exceptions\CourierInvalidArgumentException;
use Laracommerce\Core\Couriers\Exceptions\CourierNotFoundException;
use Laracommerce\Core\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CourierRepository extends BaseRepository implements CourierRepositoryInterface
{
    /**
     * CourierRepository constructor.
     * @param Courier $courier
     */
    public function __construct(Courier $courier)
    {
        parent::__construct($courier);
        $this->model = $courier;
    }

    /**
     * Create the courier
     *
     * @param array $params
     * @return Courier
     * @throws CourierInvalidArgumentException
     */
    public function createCourier(array $params) : Courier
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new CourierInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the courier
     *
     * @param array $params
     * @return Courier
     * @throws CourierInvalidArgumentException
     */
    public function updateCourier(array $params) : Courier
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new CourierInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Return the courier
     *
     * @param int $id
     * @return Courier
     * @throws CountryNotFoundException
     */
    public function findCourierById(int $id) : Courier
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CourierNotFoundException($e->getMessage());
        }
    }

    /**
     * Return all the couriers
     *
     * @param string $order
     * @param string $sort
     * @return Collection|mixed
     */
    public function listCouriers(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->where('status', 1)->orderBy($order, $sort)->get();
    }
}
