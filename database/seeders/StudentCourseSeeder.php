<?php

namespace Database\Seeders;

use App\Models\StudentCourse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the student_course seeds.
     */
    public function run(): void
    {
        // Because we all got to have the same data, we will not be using factory
        // StudentCourse::factory(30)->create();

        // Insert dummy student_courses
        $studentCourses = [
            [
                'course_id' => 1,
                'student_id' => 1,
                'semester' => 1
            ],
            [
                'course_id' => 1,
                'student_id' => 2,
                'semester' => 1
            ],
            [
                'course_id' => 4,
                'student_id' => 3,
                'semester' => 2
            ]
        ];

        $data = array_map(fn($studentCourse) => array_merge($studentCourse, ['created_at' => now()]), $studentCourses);

        DB::table('student_courses')->insert($data);
    }
}
