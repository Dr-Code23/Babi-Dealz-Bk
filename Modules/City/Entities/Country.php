<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Entities\Apartment;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }
    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }

    protected static function newFactory()
    {
        return \Modules\City\Database\factories\CountryFactory::new();
    }
}
