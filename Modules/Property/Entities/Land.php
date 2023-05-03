<?php

namespace Modules\Property\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Favorite\Entities\Favorite;

class Land extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
    protected static function newFactory()
    {
        return \Modules\Property\Database\factories\LandFactory::new();
    }
}
