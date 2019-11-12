<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCharge extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'cause_id',
        'account_id',
        'bank_id',
        'cost',
        'remarks',
        'status',
        'updated_at',
        'is_delete'
    ];
}
