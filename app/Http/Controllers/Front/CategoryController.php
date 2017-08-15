<?php

namespace App\Http\Controllers\Front;

use App\Categories\Repositories\CategoryRepository;
use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Products\Product;
use App\Tools\CurrencyTransformable;

class CategoryController extends Controller
{
    use CurrencyTransformable;

    private $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Find the category via the slug
     *
     * @param string $slug
     * @return \App\Categories\Category
     */
    public function getCategory(string $slug)
    {
        $category = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);

        $repo = new CategoryRepository($category);

        return view('front.categories.category', [
            'category' => $category,
            'products' => $repo->findProducts()
        ]);
    }
}
