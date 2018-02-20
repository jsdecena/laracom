<?php

namespace App\Shop\Carts;

use Gloudemans\Shoppingcart\Cart;

class ShoppingCart extends Cart
{
    static $defaultCurrency;

    private $session;

    private $event;

    public function __construct()
    {
        $this->session = $this->getSession();
        $this->event = $this->getEvents();
        parent::__construct($this->session, $this->event);

        self::$defaultCurrency = config('cart.currency');
    }

    public function getSession()
    {
        return app()->make('session');
    }

    public function getEvents()
    {
        return app()->make('events');
    }
}
