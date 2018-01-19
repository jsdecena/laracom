<?php

namespace App\Listeners;

use App\Events\OrderCreateEvent;
use App\Shop\Orders\Repositories\OrderRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreateEventListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreateEvent  $event
     * @return void
     */
    public function handle(OrderCreateEvent $event)
    {
        // send email to customer
        $orderRepo = new OrderRepository($event->order);
        $orderRepo->sendEmailToCustomer();

        $orderRepo = new OrderRepository($event->order);
        $orderRepo->sendEmailNotificationToAdmin();
    }
}
