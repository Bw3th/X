<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultation';
    public $timestamps = true;
    protected $fillable = ['consultation_name'];
}
    