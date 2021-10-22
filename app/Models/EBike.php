<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class EBike extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;
    protected $with = ["spare_parts"];

    protected $appends = ["image_url"];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'wheels_size',
        'power',
        'battery',
        'gear',
        'max_speed',
        'weight',
        'frame'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function spare_parts()
    {
        return $this->belongsToMany(SparePart::class);
    }
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('bikes_photo', 'thumb');
    }

}
