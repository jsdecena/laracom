<?php

namespace App\Providers;

use App\Carts\Repositories\CartRepository;
use App\Carts\ShoppingCart;
use App\Categories\Category;
use App\Categories\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class GlobalTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.admin.app', function ($view) {
            $view->with('user', Auth::guard('admin')->user());
        });

        view()->composer(['layouts.front.app', 'front.categories.sidebar-category'], function ($view) {
            $view->with('categories', $this->getCategories());
            $view->with('cartCount', $this->getCartCount());
        });
    }

    /**
     * Get all the categories
     *
     * @return array
     */
    private function getCategories()
    {
        $categoryRepo = new CategoryRepository(new Category);
        return $categoryRepo->listCategories();
    }

    private function getCartCount()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        return $cartRepo->countItems();
    }
}