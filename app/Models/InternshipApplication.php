<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InternshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'internship_period_id',
        'dosen_id',
        'motivation',
        'status',
        'rejection_reason',
        'start_date',
        'end_date',
        'approved_at',
        'verification_token',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function internshipPeriod(): BelongsTo
    {
        return $this->belongsTo(InternshipPeriod::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function logbooks(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    protected static function booted()
    {
        static::saving(function ($application) {
            if ($application->status === 'completed' && empty($application->verification_token)) {
                $application->verification_token = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    // ── Scopes ──

    /**
     * Scope: only approved or completed applications (have active/finished internship).
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['approved', 'completed']);
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // ── Helpers ──

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isActive(): bool
    {
        return $this->isApproved()
            && $this->start_date?->lte(now())
            && $this->end_date?->gte(now());
    }

    /**
     * Calculate the combined final score (average of dosen + perusahaan).
     * Returns null if either assessment is missing.
     */
    public function getCombinedScoreAttribute(): ?float
    {
        $dosenScore      = $this->assessments->where('assessor_type', 'dosen')->first()?->final_score;
        $perusahaanScore = $this->assessments->where('assessor_type', 'perusahaan')->first()?->final_score;

        return ($dosenScore && $perusahaanScore)
            ? round(($dosenScore + $perusahaanScore) / 2, 2)
            : null;
    }
}
