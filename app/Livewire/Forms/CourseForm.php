<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourseForm extends Form
{
    //region Properties

    public $id = null;

    #[Validate('required|exists:programmes,id', as: 'programme')]
    public $programme_id = null;

    #[Validate('required', as: 'name of the course')]
    public $name = null;

    #[Validate('required', as: 'description')]
    public $description = null;

    //endregion

    /**
     * Create a new course with the provided data.
     *
     * @return void
     */
    public function create(): void
    {
        // Validate the form data using Livewire validation rules.
        $this->validate();

        // Create a new course with the validated data.
        Course::create([
            'programme_id' => $this->programme_id,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }
}
