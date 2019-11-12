<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'hospital_name',
        'introduce',
        'is_delete'
    ];
}
