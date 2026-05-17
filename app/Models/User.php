<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id',
        'login_attempts', 'locked_until', 'last_login_at', 'is_active',
        'terms_accepted_at', 'terms_accepted_ip',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password'           => 'hashed',
            'locked_until'       => 'datetime',
            'last_login_at'      => 'datetime',
            'terms_accepted_at'  => 'datetime',
            'is_active'          => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function isAdmin(): bool
    {
        return $this->role?->name === 'admin';
    }

    public function isSupervisor(): bool
    {
        return $this->role?->name === 'supervisor';
    }

    public function isAsistente(): bool
    {
        return $this->role?->name === 'asistente';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role?->name, $roles);
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }
}
