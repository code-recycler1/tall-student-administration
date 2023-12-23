<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //Relationships
    //Course <-> Programme
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class)->withDefault();
    }

    //Course <-> StudentCourse
    public function studentCourses(): HasMany
    {
        return $this->hasMany(StudentCourse::class,'course_id');
    }
}
