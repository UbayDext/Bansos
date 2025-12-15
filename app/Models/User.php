<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ===== Relasi =====
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function disasters(): HasMany
    {
        return $this->hasMany(Disaster::class);
    }

    // ===== Helper Role =====
    public function isAdmin(): bool
    {
        // JAGA-JAGA: user id 1 selalu admin
        if ($this->id === 1) {
            return true;
        }

        return $this->roles()->where('name', 'admin')->exists();
    }

    public function isPartner(): bool
    {
        return $this->roles()->where('name', 'partner')->exists();
    }
}
