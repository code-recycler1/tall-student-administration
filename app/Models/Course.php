<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //region Relationships

    /**
     * Define the relationship between Course and Programme.
     *
     * @return BelongsTo
     */
    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class)->withDefault();
    }

    /**
     * Define the one-to-many relationship between Course and StudentCourse.
     *
     * @return HasMany
     */
    public function studentCourses(): HasMany
    {
        return $this->hasMany(StudentCourse::class, 'course_id');
    }

    //endregion

    //region Scopes

    /**
     * Scope to search courses by name or description.
     *
     * @param Builder $query
     * @param ?string $search
     *
     * @return Builder
     */
    public function scopeSearchNameOrDescription(Builder $query, ?string $search = '%'): Builder
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }

    //endregion
}
