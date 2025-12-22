<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'uloga_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function uloga(): BelongsTo
    {
        return $this->belongsTo(Uloga::class);
    }

    public function isAdmin(): bool
    {
        return $this->uloga?->naziv === 'Admin';
    }

    public function isProdavac(): bool
    {
        return $this->uloga?->naziv === 'Prodavac';
    }
}
