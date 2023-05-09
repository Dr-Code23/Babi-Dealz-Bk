<?php

namespace Modules\Auth\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendDeal extends Model
{
    use HasFactory;

    protected $table = 'send_deals';
    protected $guarded = [];



    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

}
