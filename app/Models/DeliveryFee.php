<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DeliveryFee extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'min_weight',
        'delivery_fee'
    ];
}
