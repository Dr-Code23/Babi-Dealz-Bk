<?php

namespace Modules\PropertyType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\PropertyType\Database\factories\PropertyTypeFactory::new();
    }
}
