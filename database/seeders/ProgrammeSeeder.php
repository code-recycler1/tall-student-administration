<?php

namespace Database\Seeders;

use App\Models\Programme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the programme seeds.
     */
    public function run(): void
    {
        // Because we all got to have the same data, we will not be using factory
        // Programme::factory(10)->create();

        // Insert dummy programmes
        $programmes = [
            [
                'name' => 'IT Factory'
            ],
            [
                'name' => 'Office Management'
            ],
            [
                'name' => 'Business and Tourism'
            ],
            [
                'name' => 'Media and Communication'
            ],
            [
                'name' => 'People & Health'
            ]
        ];

        $data = array_map(fn($programme) => array_merge($programme, ['created_at' => now()]), $programmes);

        DB::table('programmes')->insert($data);
    }
}
