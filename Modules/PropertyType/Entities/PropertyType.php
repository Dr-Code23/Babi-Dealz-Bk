<?php

namespace Modules\PropertyType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Entities\Apartment;

class PropertyType extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }
    protected static function newFactory()
    {
        return \Modules\PropertyType\Database\factories\PropertyTypeFactory::new();
    }
}
