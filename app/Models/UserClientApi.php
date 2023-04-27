<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClientApi extends Model
{
    protected $fillable = [
        'user_id', 'product_id',
    ];
}
