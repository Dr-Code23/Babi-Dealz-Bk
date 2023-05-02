<?php

namespace Modules\Favorite\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Service\Entities\Service;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function favoritable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return \Modules\Favorite\Database\factories\FavoriteFactory::new();
    }
}
