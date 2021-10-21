<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\EBike;

class EBikeUser extends Model
{
    protected $table = "e_bike_user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'e_bike_id',
        'order_number',
        'name'
    ];


    public function e_bike()
    {
        return $this->belongsTo(EBike::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
