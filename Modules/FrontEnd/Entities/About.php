<?php

namespace Modules\FrontEnd\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Database\factories\AboutFactory;

class About extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'about';

    protected static function newFactory()
    {
        return AboutFactory::new();
    }
}
