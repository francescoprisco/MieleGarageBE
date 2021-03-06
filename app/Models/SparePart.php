<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePart extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;

    protected $appends = ["image_url"];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'qty',
        'price',
        'weight'
    ];

    public function e_bikes()
    {
        return $this->belongsToMany(EBike::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('spare_parts_photo', 'thumb');
    }
}
