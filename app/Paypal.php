<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'transaction_id', 'email', 'country', 'state', 'city', 'total'

    ];
}
