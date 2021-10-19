<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'payment_option_id',
        'delivery_address_id',
        'code',
        'total_amount',
        'sub_total_amount',
        'delivery_fee',
        'status',
        'payment_status',
        'time_slot',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'payment_option_id' => 'integer',
        'delivery_address_id' => 'integer',
        'total_amount' => 'double',
        'sub_total_amount' => 'double',
        'delivery_fee' => 'double',
    ];


    protected static function booted()
    {

        static::updated(function ($order) {
            //
            if( $order->status == "failed" && $order->paymentOption->slug == "wallet" ){
                $wallet = Wallet::where('user_id', $order->user_id)->first();
                $wallet->balance += $order->total_amount;
                $wallet->save();
            }
        });

    }


    public function spare_parts()
    {
        return $this->hasMany(\App\Models\OrderSparePart::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class)->withTrashed();
    }
    public function paymentOption()
    {
        return $this->belongsTo(\App\Models\PaymentOption::class)->withTrashed();
    }

    public function deliveryAddress()
    {
        return $this->belongsTo(\App\Models\DeliveryAddress::class)->withTrashed();
    }
}
