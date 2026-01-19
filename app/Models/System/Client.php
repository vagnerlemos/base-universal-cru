<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'city',
    ];
}
