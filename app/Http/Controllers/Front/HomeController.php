<?php

namespace App\Http\Controllers\Front;

use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $newests = $this->categoryRepo->findProductsInCategory(1);
        $features = $this->categoryRepo->findProductsInCategory(2);

        return view('front.index', compact('newests', 'features'));
    }

    public function landing()
    {
        return view('layouts.front.landing');
    }
}