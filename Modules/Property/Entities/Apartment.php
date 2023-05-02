<?php

namespace Modules\Property\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Feature\Entities\Feature;


class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [];

//    public function city()
//    {
//        return $this->belongsTo(City::class);
//    }

//    public function apartments()
//    {
//        return $this->hasMany(Apartment::class);
//    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\ApartmentFactory::new();
    }
}
