<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malhal\Geographical\Geographical;

class DeliveryAddress extends Model
{
    use SoftDeletes, Geographical;

    //
    protected static $kilometers = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'user_id',
        'is_default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'is_default' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
