<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    protected $fillable = [
        'ruc', 'razon_social', 'tipo_contribuyente',
        'direccion_fiscal', 'estado', 'created_by', 'updated_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function solCredential(): HasOne
    {
        return $this->hasOne(SolCredential::class);
    }

    public function accessLogs(): HasMany
    {
        return $this->hasMany(AccessLog::class);
    }

    public function hasCredentials(): bool
    {
        return $this->solCredential()->exists();
    }

    public function scopeActive($query)
    {
        return $query->where('estado', 'ACTIVO');
    }

    public function scopeSearch($query, ?string $term)
    {
        if (!$term) return $query;
        return $query->where(function ($q) use ($term) {
            $q->where('ruc', 'like', "%{$term}%")
              ->orWhere('razon_social', 'like', "%{$term}%");
        });
    }
}
