<?php

namespace App\Shop\Shipping\Shippo;

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use App\Shop\Products\Product;
use App\Shop\Shipping\ShippingInterface;
use Illuminate\Support\Collection;
use Shippo;
use Shippo_Shipment;

class ShippoShipmentRepository implements ShippingInterface
{
    /**
     * @var Customer
     */
    protected $customer;

    /**
     * The address where to pick up the item for delivery
     *
     * @var $warehouseAddress
     */
    protected $warehouseAddress;

    /**
     * The address of the customer where the item is to be delivered
     *
     * @var $deliveryAddress
     */
    protected $deliveryAddress;

    /**
     * The item/s
     *
     * @var $parcel
     */
    protected $parcel;

    /**
     * Shipment
     *
     * @var $shipment
     */
    protected $shipment;

    /**
     * ShippoShipment constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        Shippo::setApiKey(config('shop.shipping_token'));

        $this->customer = $customer;
    }

    /**
     * Address where the shipment will be picked up
     */
    public function setPickupAddress()
    {
        $warehouse = [
            'name' => config('app.name'),
            'street1' => config('shop.warehouse.address_1'),
            'city' => config('shop.warehouse.city'),
            'state' => config('shop.warehouse.state'),
            'zip' => config('shop.warehouse.zip'),
            'country' => config('shop.warehouse.country'),
            'phone' => config('shop.phone'),
            'email' => config('shop.email')
        ];

        $this->warehouseAddress = $warehouse;
    }

    /**
     * @param Address $address
     */
    public function setDeliveryAddress(Address $address)
    {
        $delivery =  [
            'name' => $address->alias,
            'street1' => $address->address_1,
            'city' => $address->city,
            'state' => $address->state_code,
            'zip' => $address->zip,
            'country' => $address->country->iso,
            'phone' => '',
            'email' => $this->customer->email
        ];

        $this->deliveryAddress = $delivery;
    }

    /**
     * @return \Shippo_Shipment
     */
    public function readyShipment()
    {
        $shipment = Shippo_Shipment::create(array(
                'address_from'=> $this->warehouseAddress,
                'address_to'=> $this->deliveryAddress,
                'parcels'=> $this->parcel,
                'async'=> false
            )
        );

        return $shipment;
    }

    /**
     * @param string $id
     * @param string $currency
     *
     * @return \Shippo_Shipment
     */
    public function getRates(string $id, string $currency = 'USD')
    {
        return Shippo_Shipment::get_shipping_rates(compact('id', 'currency'));
    }

    /**
     * @param Collection $collection
     *
     * @return void
     */
    public function readyParcel(Collection $collection)
    {
        $weight = $collection->map(function ($item) {
            return [
                'weight' => $item->product->weight * $item->qty,
                'mass_unit' => $item->product->mass_unit
            ];
        })->map(function ($item) {
            $total = 0;
            switch ($item['mass_unit']) {
                case Product::MASS_UNIT['OUNCES'] :
                    $oz = $item['weight'] / 16;
                    $total += $oz;
                    break;
                case Product::MASS_UNIT['GRAMS'] :
                    $oz = $item['weight'] *  0.0022;
                    $total += $oz;
                    break;
                default:
                    $total += $item['weight'];
            }
            return [
                'weight' => $total
            ];
        })->sum('weight');

        $parcel = array(
            'length'=> '5',
            'width'=> '5',
            'height'=> '5',
            'distance_unit'=> 'in',
            'weight'=> $weight,
            'mass_unit'=> 'lb',
        );

        $this->parcel = $parcel;
    }
}