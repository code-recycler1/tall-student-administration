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
    public $perPage = 6;

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

        $allCourses = Course::orderBy('name')->withCount('studentCourses')->paginate($this->perPage);

        return view('livewire.courses-overview', compact('allCourses', 'allProgrammes'));
    }

    public function showCourseDetails(Course $course): void
    {
        $this->selectedCourse = $course->load('studentCourses.student');
        $this->showCourseDetailsModal = true;
    }
}
