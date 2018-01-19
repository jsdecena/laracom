<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
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
        $category2 = $this->categoryRepo->find(2);
        $category3 = $this->categoryRepo->find(3);

        $newests = $this->categoryRepo->findProductsInCategory($category2->id);

        $features = $this->categoryRepo->findProductsInCategory($category3->id);

        return view('front.index', compact('newests', 'features', 'category2', 'category3'));
    }
}
