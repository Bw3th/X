<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTag extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tag',
        'introduce',
        'is_delete'
    ];
}
