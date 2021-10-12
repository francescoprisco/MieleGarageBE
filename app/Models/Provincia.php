<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Provincia extends Model
{
    protected $table = "province";
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $with = ['cities'];
    protected $fillable = [
        'name',
        'codice'
    ];
    public function cities()
    {
        return $this->hasMany(City::class,'provincia_id');
    }
}
