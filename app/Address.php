<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $table = 'address';
    protected $fillable = [
        'user_id', 'address', 'city', 'nation', 'zip_code'
    ];
}
