<?php

namespace Modules\Property\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\City\Entities\City;
use Modules\City\Entities\Country;
use Modules\Favorite\Entities\Favorite;
use Modules\Feature\Entities\Feature;
use Modules\PropertyType\Entities\PropertyType;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Hangar extends Model  implements HasMedia
{
    use HasFactory ,InteractsWithMedia;

    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    public function propertytype()
    {
        return $this->belongsTo(PropertyType::class,'property_type_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_property');
    }

    public function getAllMediaUrls(string $collectionName = 'default'): array
    {
        return $this->getMedia($collectionName)
            ->map(fn ($media) => $media->getUrl())
            ->toArray();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\HangarFactory::new();
    }
}
