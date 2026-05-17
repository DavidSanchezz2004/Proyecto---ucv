<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponse extends Model
{
    protected $fillable = [
        'respondent_id', 'question_id', 'score', 'responded_at',
    ];

    protected function casts(): array
    {
        return ['responded_at' => 'datetime'];
    }

    public function respondent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'respondent_id');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }
}
