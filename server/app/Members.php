<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $fillable = [
        'name',
        'sex',
        'company',
        'mobile',
        'IDcard',
        'bank_id',
        'is_delete'
    ];

}
