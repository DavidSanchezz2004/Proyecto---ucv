<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestion extends Model
{
    protected $fillable = [
        'variable', 'dimension', 'sub_dimension',
        'order_number', 'question_text', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class, 'question_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order_number');
    }
}
