<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\PayuTrait;

class PaymentController extends Controller
{
    use PayuTrait;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
