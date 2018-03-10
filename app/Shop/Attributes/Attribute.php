<?php

namespace App\Shop\Attributes;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'value'
    ];
}