<?php

namespace App\Shop\Shipping\Shippo;

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use App\Shop\Products\Product;
use App\Shop\Shipping\ShippingInterface;
use Illuminate\Support\Collection;
use Shippo;
use Shippo_Shipment;

class ShippoShipment implements ShippingInterface
{
    /**
     * @var Customer
     */
    protected $customer;

    protected $billingAddress;

    protected $deliveryAddress;

    protected $parcel;

    protected $shipment;

    /**
     * ShippoShipment constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        Shippo::setApiKey(env('SHIPPO_API_TOKEN'));

        $this->customer = $customer;
    }

    public function setBillingAddress(Address $address)
    {
        $billing = [
            'name' => $address->alias,
            'street1' => $address->address_1,
            'city' => '',
            'state' => '',
            'zip' => $address->zip,
            'country' => $address->country->iso,
            'phone' => '',
            'email' => $this->customer->email
        ];

        $this->billingAddress = $billing;
    }

    public function setDeliveryAddress(Address $address)
    {
        $delivery =  [
            'name' => $address->alias,
            'street1' => $address->address_1,
            'city' => '',
            'state' => '',
            'zip' => $address->zip,
            'country' => $address->country->iso,
            'phone' => '',
            'email' => $this->customer->email
        ];

        $this->deliveryAddress = $delivery;
    }

    /**
     * @return Shippo_Shipment
     */
    public function readyShipment()
    {
        $shipment = Shippo_Shipment::create(array(
                'address_from'=> $this->billingAddress,
                'address_to'=> $this->deliveryAddress,
                'parcels'=> [$this->parcel],
                'async'=> false
            )
        );

        return $shipment;
    }

    /**
     * @param string $id
     * @param string $currency
     *
     * @return \Shippo_Get_Shipping_Rates
     */
    public function getRates(string $id, string $currency = 'USD')
    {
        return Shippo_Shipment::get_shipping_rates(compact('id', 'currency'));
    }

    /**
     * @param Collection $collection
     *
     * @return array
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