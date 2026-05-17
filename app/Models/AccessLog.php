<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessLog extends Model
{
    protected $fillable = [
        'company_id', 'user_id', 'ruc', 'razon_social',
        'duration_ms', 'duration_seconds', 'status',
        'steps_completed', 'error_message', 'ip_address',
        'user_agent', 'accessed_at',
    ];

    protected function casts(): array
    {
        return [
            'accessed_at'      => 'datetime',
            'duration_seconds' => 'decimal:3',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'SUCCESS');
    }

    public function scopeByDateRange($query, ?string $from, ?string $to)
    {
        if ($from) $query->where('accessed_at', '>=', $from . ' 00:00:00');
        if ($to)   $query->where('accessed_at', '<=', $to . ' 23:59:59');
        return $query;
    }
}
