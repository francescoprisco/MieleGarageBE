<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Provincia;
use App\Models\City;

class Profile extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;

    protected $with = "media";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'surname',
        'phone',
        'provincia_id',
        'city_id',
        'address',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
