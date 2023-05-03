<?php

namespace Modules\Property\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\City\Entities\Country;

use Modules\Favorite\Entities\Favorite;
use Modules\PropertyType\Entities\PropertyType;
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
        return $this->belongsTo(PropertyType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
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
