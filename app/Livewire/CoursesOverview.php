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

    public $loading = 'Please wait...';
    public $nameOrDescription;
    public $programme = '%';
    public $perPage = 6;
    public $perPageOptions = [6, 9, 12, 15, 18, 24];

    public $selectedCourse;
    public $showCourseDetailsModal = false;

    #[Layout('layouts.studentadministration', [
        'title' => 'Courses',
        'description' => 'Courses',
    ])]
    public function render(): View
    {
        sleep(2);

        $allProgrammes = Programme::orderBy('name')->get();

        $allCourses = Course::orderBy('name')
            ->searchNameOrDescription($this->nameOrDescription)
            ->where('programme_id', 'like', $this->programme)
            ->withCount('studentCourses')->paginate($this->perPage);

        return view('livewire.courses-overview', compact('allCourses', 'allProgrammes'));
    }

    public function showCourseDetails(Course $course): void
    {
        $this->selectedCourse = $course->load('studentCourses.student');
        $this->showCourseDetailsModal = true;
    }

    public function updated($property, $value): void
    {
        if (in_array($property, ['perPage', 'nameOrDescription', 'programme']))
            $this->resetPage();
    }
}
