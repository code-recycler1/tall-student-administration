<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // StudentCourse <-> Course
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
