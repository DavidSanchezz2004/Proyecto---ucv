<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'description', 'ip_address', 'user_agent', 'metadata', 'created_at',
    ];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, ?string $description = null, array $extra = []): void
    {
        static::create(array_merge([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => substr(request()->userAgent() ?? '', 0, 500),
            'created_at'  => now(),
        ], $extra));
    }
}
