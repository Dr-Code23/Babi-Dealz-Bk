<?php

namespace Modules\Property\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Favorite\Entities\Favorite;
use Modules\Feature\Entities\Feature;

class Villa extends Model
{
    use HasFactory;

    protected $fillable = [];





    public function getAllMediaUrls(string $collectionName = 'default'): array
    {
        return $this->getMedia($collectionName)
            ->map(fn ($media) => $media->getUrl())
            ->toArray();
    }
    public function features()
    {
        return $this->belongsToMany(Feature::class,'feature_property')->withTimestamps();
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\VillaFactory::new();
    }
}
