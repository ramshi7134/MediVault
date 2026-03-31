<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'title',
        'hospital_name',
        'doctor_name',
        'visit_date',
        'document_type',
        'file_path',
        'file_mime',
        'file_size',
        'extracted_text',
        'ocr_status',
        'tags',
        'group',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'tags' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function sharedRecords(): HasMany
    {
        return $this->hasMany(SharedRecord::class);
    }
}
