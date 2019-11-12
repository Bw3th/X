<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    protected $table = 'service_charge';
    public $timestamps = true;
    protected $fillable = [
        'consultation_id',
        'accout_id',
        'cost',
        'bank_num',
        'opening_bank',
        'status'
    ];

}
