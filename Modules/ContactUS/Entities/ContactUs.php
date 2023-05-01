<?php

namespace Modules\ContactUS\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ContactUS\Database\factories\ContactUsFactory;

class ContactUs extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected static function newFactory()
    {
        return ContactUsFactory::new();
    }
}
