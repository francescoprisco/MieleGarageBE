<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class City extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];
    public function provincia()
    {
        return $this->hasOne(Provincia::class);
    }
}
