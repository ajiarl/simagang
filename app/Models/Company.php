<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'description',
        'contact_person',
        // 'logo_path' — tidak di-mass-assign, hanya via upload khusus
        // 'is_active' — tidak di-mass-assign, hanya via toggle admin
    ];

    public function internshipApplications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
