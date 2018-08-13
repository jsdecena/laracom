<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayuMoney extends Model
{

    protected $table = 'payu_payments';
    protected $fillable = [
        "txnid",
        "mihpayid",
        "firstname",
        "email",
        "phone",
        "amount",
        "status",
        "unmappedstatus",
        "mode",
        "bank_ref_num",
        "bankcode",
        "data",
        "account"
    ];
}
