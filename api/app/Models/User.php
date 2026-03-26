<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'google_token_expires_at' => 'datetime',
        'birth_date' => 'date',
    ];

    protected function cpf(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? preg_replace('/\D/', '', $value) : null
        );
    }

    public function isRegistrationComplete(): bool
    {
        return ! empty($this->name)
            && ! empty($this->cpf)
            && ! empty($this->birth_date);
    }

    protected function cpfFormatted(): Attribute
    {
        return Attribute::make(
            get: fn ($attributes) => isset($attributes['cpf'])
                ? preg_replace(
                    '/(\d{3})(\d{3})(\d{3})(\d{2})/',
                    '$1.$2.$3-$4',
                    $attributes['cpf']
                )
                : null
        );
    }
}
