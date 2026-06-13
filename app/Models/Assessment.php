<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'internship_application_id',
        'assessor_id',
        'assessor_type',
        'discipline',
        'attitude',
        'skills',
        'communication',
        'initiative',
        'final_score',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'discipline' => 'integer',
            'attitude' => 'integer',
            'skills' => 'integer',
            'communication' => 'integer',
            'initiative' => 'integer',
            'final_score' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function internshipApplication(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class);
    }

    public function assessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }
}
