<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
    ];

    //Relationships

    /**
     * Define the relationship between Student and Programme.
     *
     * @return BelongsTo
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class)->withDefault();
    }

    /**
     * Define the relationship between Student and StudentCourse.
     *
     * @return HasMany
     */
    public function studentCourses(): HasMany
    {
        return $this->hasMany(StudentCourse::class, 'student_id');
    }
}
