<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCause extends Model
{
    protected $fillable = [
        'cause_name',
        'cause_type',
        'proness_status',
        'final_status',
        'begin_time',
        'updated_at',
        'is_delete',
        'pay_time'
    ];
}
