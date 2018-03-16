<?php

namespace App\Shop\PaymentMethods\Stripe;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Checkout\CheckoutRepository;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\PaymentMethods\Stripe\Exceptions\StripeChargingErrorException;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Stripe\Charge;

class StripeRepository
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * StripeRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param string $token
     * @param Request $request
     * @return Charge
     * @throws StripeChargingErrorException
     */
    public function execute(string $token, Request $request)
    {
        try {

            if(!$this->validateFields($request->all())){
                return redirect()->route('checkout.index')
                    ->withInput()
                    ->with('error', 'You must select the shipping and delivery address');
            }

            $courierRepo = new CourierRepository(new Courier);
            $courierId = $request->input('courier');
            $courier = $courierRepo->findCourierById($courierId);

            $charge = Cart::total() + $courier->cost;

            $customerRepo = new CustomerRepository($this->customer);
            $options['source'] = $token;
            $options['currency'] = config('cart.currency');

            if($result = $customerRepo->charge($charge, $options)) {
                $checkoutRepo = new CheckoutRepository;
                $checkoutRepo->buildCheckoutItems([
                    'reference' => Uuid::uuid4()->toString(),
                    'courier_id' => $request->input('courier'),
                    'customer_id' => auth()->user()->id,
                    'address_id' => $request->input('billing_address'),
                    'order_status_id' => 1,
                    'payment' => strtolower(config('stripe.name')),
                    'discounts' => 0,
                    'total_products' => Cart::total(),
                    'total' => $charge,
                    'total_paid' => $charge,
                    'tax' => Cart::tax()
                ]);

                Cart::destroy();

                return redirect()->route('checkout.success');
            }
        } catch (\Exception $e) {
            throw new StripeChargingErrorException($e);
        }

    }

    /**
     * @param array $fields
     * @return bool
     */
    private function validateFields(array $fields) : bool
    {
        $validator = Validator::make($fields, [
            'courier' => 'required',
            'billing_address' => 'required',
        ]);

        if ($validator->fails()) {
            return false;
        }
        return true;
    }
}