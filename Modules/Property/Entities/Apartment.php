<?php

namespace Modules\Property\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\City\Entities\Country;
use Modules\Feature\Entities\Feature;

use Modules\Favorite\Entities\Favorite;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Apartment extends Model implements HasMedia
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
    public function propertyType()
    {
        return $this->belongsTo(Property::class, 'property_type_id','id');
    }





    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\ApartmentFactory::new();
    }
}
