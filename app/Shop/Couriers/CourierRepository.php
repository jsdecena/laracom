<?php

namespace App\Shop\Couriers\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Exceptions\CourierInvalidArgumentException;
use App\Shop\Couriers\Exceptions\CourierNotFoundException;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
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
     *
     * @return bool
     * @throws CourierInvalidArgumentException
     */
    public function updateCourier(array $params) : bool
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new CourierInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Return the courier
     *
     * @param int $id
     *
     * @return Courier
     * @throws CourierNotFoundException
     */
    public function findCourierById(int $id) : Courier
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CourierNotFoundException('Courier not found.');
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
        return $this->all(['*'], $order, $sort);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCourier()
    {
        return $this->delete();
    }
}
