<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the course seeds.
     */
    public function run(): void
    {
        // Because we all got to have the same data, we will not be using factory
        // Course::factory(20)->create();

        // Insert dummy courses
        $courses = [
            [
                'programme_id' => 1,
                'name' => 'PHP',
                'description' => 'Develop web applications in PHP using Laravel'
            ],
            [
                'programme_id' => 1,
                'name' => 'Webdesign Essentials',
                'description' => 'Learn the basics of web development'
            ],
            [
                'programme_id' => 1,
                'name' => 'IoT Essentials',
                'description' => 'Internet of Things is awesome!'
            ],
            [
                'programme_id' => 2,
                'name' => 'Communication',
                'description' => 'Learn to communicate with other people'
            ],
            [
                'programme_id' => 2,
                'name' => 'Intercultural Relations Management',
                'description' => 'Be ready to conquer the world'
            ],
            [
                'programme_id' => 5,
                'name' => 'Anatomy',
                'description' => 'Study the structure of organisms and their parts'
            ],
            [
                'programme_id' => 5,
                'name' => 'How To Communicate As A Caregiver?',
                'description' => 'Communication strategies between caregiver and patient'
            ],
        ];

        $data = array_map(fn($course) => array_merge($course, ['created_at' => now()]), $courses);

        DB::table('courses')->insert($data);
    }
}
