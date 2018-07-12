<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $fillable = [

        'name', 'date', 'email', 'phone_number', 'office', 'filename'

    ];
}
