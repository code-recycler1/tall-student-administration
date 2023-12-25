<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourseForm extends Form
{
    public $id = null;

    #[Validate('required|exists:programmes,id', as: 'programme')]
    public $programme_id = null;

    #[Validate('required', as: 'name of the course')]
    public $name = null;

    #[Validate('required', as: 'description')]
    public $description = null;

    public function create(): void
    {
        $this->validate();

        Course::create([
            'programme_id' => $this->programme_id,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}
