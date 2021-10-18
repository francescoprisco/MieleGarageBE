<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'double',
    ];


    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class)->withTrashed();
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\SparePart::class)->withTrashed();
    }
}
