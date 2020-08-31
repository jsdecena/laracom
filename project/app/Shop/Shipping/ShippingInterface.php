<?php

namespace App\Shop\Shipping;

use App\Shop\Addresses\Address;
use Illuminate\Support\Collection;

interface ShippingInterface
{
    public function setPickupAddress();

    public function setDeliveryAddress(Address $address);

    public function readyParcel(Collection $collection);

    public function getRates(string $shipmentObjId, string $currency = 'USD');

    public function readyShipment();
}