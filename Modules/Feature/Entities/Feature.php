<?php

namespace Modules\Feature\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Entities\Apartment;
use Modules\Property\Entities\Hangar;
use Modules\Property\Entities\Land;
use Modules\Property\Entities\Shop;
use Modules\Property\Entities\Villa;
use Spatie\Translatable\HasTranslations;


class Feature extends Model
{

    use HasFactory;

    protected $guarded = [];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class)->withTimestamps();
    }

    public function villas()
    {
        return $this->belongsToMany(Villa::class)->withTimestamps();
    }

    public function lands()
    {
        return $this->belongsToMany(Land::class)->withTimestamps();
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class)->withTimestamps();
    }

    public function hangars()
    {
        return $this->belongsToMany(Hangar::class)->withTimestamps();
    }
//    protected static function newFactory()
//    {
//        return \Modules\Feature\Database\factories\FeatureFactory::new();
//    }


}
