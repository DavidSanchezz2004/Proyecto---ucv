<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class SolCredential extends Model
{
    protected $fillable = [
        'company_id', 'usuario_sol', 'clave_sol',
        'last_verified_at', 'created_by', 'updated_by',
    ];

    // La clave nunca se serializa en JSON ni en arrays
    protected $hidden = ['clave_sol'];

    protected function casts(): array
    {
        return [
            'last_verified_at' => 'datetime',
        ];
    }

    // Cifra automáticamente al guardar
    public function setClavesolAttribute(string $value): void
    {
        $this->attributes['clave_sol'] = Crypt::encryptString($value);
    }

    // Descifra automáticamente al leer (solo para uso interno del servidor)
    public function getClavesolAttribute(string $value): string
    {
        return Crypt::decryptString($value);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
