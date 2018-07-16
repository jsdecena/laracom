<?php

namespace App\Http\Controllers\Front\Addresses;

use App\Http\Controllers\Controller;
use App\Shop\States\Repositories\StateRepository;
use App\Shop\States\Repositories\StateRepositoryInterface;

class StateCityController extends Controller
{
    private $stateRepo;

    /**
     * StateCityController constructor.
     *
     * @param StateRepositoryInterface $stateRepository
     */
    public function __construct(StateRepositoryInterface $stateRepository)
    {
        $this->stateRepo = $stateRepository;
    }

    /**
     * @param $state_code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($state_code)
    {
        $state = $this->stateRepo->findOneBy(compact('state_code'));

        $stateRepo = new StateRepository($state);
        $data = $stateRepo->listCities();

        return response()->json(compact('data'));
    }
}