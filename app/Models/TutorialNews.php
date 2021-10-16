<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TutorialNews extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $appends = ["image_url","video_url"];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'type',
    ];

    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('newstutorial_photo', 'thumb');
    }
    public function getVideoUrlAttribute()
    {
        return $this->getFirstMediaUrl('newstutorial_video');
    }
}
