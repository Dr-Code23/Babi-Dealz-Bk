<?php

namespace Modules\Feature\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Entities\Apartment;
use Spatie\Translatable\HasTranslations;


class Feature extends Model
{

    use HasFactory;
//    use HasTranslations;

//    public $translatable = ['title'];

    protected $guarded = [];


//    protected static function newFactory()
//    {
//        return \Modules\Feature\Database\factories\FeatureFactory::new();
//    }


}
