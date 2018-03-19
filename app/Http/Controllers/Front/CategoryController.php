<?php

namespace App\Http\Controllers\Front;

use Laracommerce\Core\Categories\Repositories\CategoryRepository;
use Laracommerce\Core\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Find the category via the slug
     *
     * @param string $slug
     * @return \Laracommerce\Core\Categories\Category
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
