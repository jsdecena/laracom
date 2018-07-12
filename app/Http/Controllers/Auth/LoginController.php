<?php

namespace App\Http\Controllers\Auth;

use App\Shop\Admins\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\Shop\Customers\Customer;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/accounts';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login the admin
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $details = $request->only('email', 'password');
        $details['status'] = 1;
        if (auth()->attempt($details)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param $account
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSocialRedirect($account)
    {
        try {
            return Socialite::with( $account )->redirect();
        }
        catch (\InvalidArgumentException $exception)
        {
            return redirect('/login');
        }
    }

    public function getSocialCallback($account)
    {
        $socialUser = Socialite::with( $account )->user();

        $existingCustomer = Customer::where( 'email', '=', $socialUser->email )->first();

        if( $existingCustomer == null ){
            $newCustomer = new Customer();
            $newCustomer->name        = $socialUser->getName();
            $newCustomer->email       = $socialUser->getEmail() == '' ? '' : $socialUser->getEmail();
            $newCustomer->avatar      = $socialUser->getAvatar();
            $newCustomer->password    = '';
            $newCustomer->provider    = $account;
            $newCustomer->provider_id = $socialUser->getId();
            $newCustomer->save();
            return $this->loginUserAndRedirect($newCustomer);
        } else {
            $existingCustomer->provider = $account;
            $existingCustomer->provider_id = $socialUser->getId();
            $existingCustomer->avatar = $socialUser->getAvatar();
            $existingCustomer->update();
            return $this->loginUserAndRedirect($existingCustomer);
        }
    }

    public function loginUserAndRedirect($customer)
    {
        if(!empty($customer)) {
            Auth::login( $customer );
            return redirect('/');
        }
    }
}
