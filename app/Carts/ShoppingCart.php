<?php

namespace App\Carts;

use Gloudemans\Shoppingcart\Cart;

class ShoppingCart extends Cart
{
    private $session;

    private $event;

    public function __construct()
    {
        $this->session = $this->getSession();
        $this->event = $this->getEvents();
        parent::__construct($this->session, $this->event);
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