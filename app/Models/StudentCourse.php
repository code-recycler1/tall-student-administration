<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentCourse extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // Relationships
    // StudentCourse <-> Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // StudentCourse <-> Course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
