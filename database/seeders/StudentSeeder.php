<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the student seeds.
     */
    public function run(): void
    {
        // Because we all got to have the same data, we will not be using factory
        // Student::factory(40)->create();

        // Insert dummy students
        $students = [
            [
                'programme_id' => 1,
                'student_number' => 1,
                'first_name' => 'Rik',
                'last_name' => 'Rikken'
            ],
            [
                'programme_id' => 1,
                'student_number' => 2,
                'first_name' => 'Jos',
                'last_name' => 'Jossen'
            ],
            [
                'programme_id' => 2,
                'student_number' => 1,
                'first_name' => 'Gert',
                'last_name' => 'Gerten'
            ]
        ];

        $data = array_map(fn($student) => array_merge($student, ['created_at' => now()]), $students);

        DB::table('students')->insert($data);
    }
}
