<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'google_id',
        'google_access_token',
        'google_refresh_token',
        'google_token_expires_at',
        'email',
        'email_verified_at',
        'name',
        'cpf',
        'birth_date',
    ];
}
