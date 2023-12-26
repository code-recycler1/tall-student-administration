<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Programme;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class CoursesOverview extends Component
{
    use WithPagination;

    //region Properties

    public $loading = 'Please wait...';
    public $nameOrDescription;
    public $programme = '%';
    public $perPage = 6;
    public $perPageOptions = [6, 9, 12, 15, 18, 24];

    public $selectedCourse;
    public $showCourseDetailsModal = false;

    //endregion

    //region Methods

    #[Layout('layouts.studentadministration', [
        'title' => 'Courses',
        'description' => 'Courses',
    ])]
    public function render(): View
    {
        // Simulate a delay for a better user experience.
        sleep(2);

        // Retrieve all programmes for dropdown ordering by name.
        $allProgrammes = Programme::orderBy('name')->get();

        // Retrieve all courses with counts of associated student courses, filtered by name or description and programme.
        $allCourses = Course::orderBy('name')
            ->searchNameOrDescription($this->nameOrDescription)
            ->where('programme_id', 'like', $this->programme)
            ->withCount('studentCourses')->paginate($this->perPage);

        return view('livewire.courses-overview', compact('allCourses', 'allProgrammes'));
    }

    /**
     * Display details for a specific course.
     *
     * @param  Course  $course
     *
     * @return void
     */
    public function showCourseDetails(Course $course): void
    {
        // Load the selected course with associated student courses and students.
        $this->selectedCourse = $course->load('studentCourses.student');

        // Display the course details modal.
        $this->showCourseDetailsModal = true;
    }

    /**
     * Handle property updates and reset the Livewire page if necessary.
     *
     * @param  string  $property
     * @param  mixed   $value
     *
     * @return void
     */
    public function updated(string $property, mixed $value): void
    {
        // Reset the Livewire page if the updated property is one of ['perPage', 'nameOrDescription', 'programme'].
        if (in_array($property, ['perPage', 'nameOrDescription', 'programme']))
            $this->resetPage();
    }

    //endregion
}
