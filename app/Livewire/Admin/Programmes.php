<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\CourseForm;
use App\Models\Programme;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Str;

class Programmes extends Component
{
    use WithPagination;

    //region Properties

    public $loading = 'Please wait...';
    public $perPage = 10;
    public $orderBy = 'name';
    public $orderAsc = true;
    public $showModal = false;

    public CourseForm $form;
    public $selectedProgramme;

    #[Validate(
        'required|min:3|max:30|unique:programmes,name',
        attribute: 'name for this programme',
    )]
    public $newProgramme;

    #[Validate([
        'editProgramme.name' => 'required|min:3|max:30|unique:programmes,name',
    ], as: [
        'editProgramme.name' => 'name for this programme',
    ])]
    public $editProgramme = ['id' => null, 'name' => null];

    //endregion

    //region Methods

    #[Layout('layouts.studentadministration', ['title' => 'Programmes', 'description' => 'Manage the programmes',])]
    public function render(): View
    {
        // Retrieve all programmes with the count of associated courses.
        $allProgrammes = Programme::withCount('courses')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.programmes', compact('allProgrammes'));
    }

    /**
     * Resort programmes based on the selected column.
     *
     * @param string $column
     *
     * @return void
     */
    public function resort(string $column): void
    {
        // Toggle the sorting order if the selected column is the same as the current sorting column.
        // Otherwise, set the sorting order to 'ascending' and update the sorting column.
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    /**
     * Reset form values and error messages.
     *
     * @return void
     */
    public function resetValues(): void
    {
        // Reset the values of newProgramme and editProgramme.
        $this->reset(['newProgramme', 'editProgramme']);

        // Reset any previous error messages.
        $this->resetErrorBag();
    }

    /**
     * Create a new programme using the provided data.
     *
     * @return void
     */
    public function create(): void
    {
        // Validate the new programme name using Livewire validation rules.
        $this->validateOnly('newProgramme');

        // Create a new programme with the trimmed name.
        $programme = Programme::create(['name' => trim($this->newProgramme)]);

        // Reset form values after successfully creating the programme.
        $this->resetValues();

        // Show a success toast message with the name of the added programme.
        $this->showToast('success', "The programme <b><i>$programme->name</i></b> has been added.");
    }

    /**
     * Prepare the data for editing a programme.
     *
     * @param  Programme  $programme
     *
     * @return void
     */
    public function edit(Programme $programme): void
    {
        // Set the editProgramme property with the specified fields from the given programme.
        $this->editProgramme = $programme->only('id', 'name');
    }

    /**
     * Update a programme's information.
     *
     * @param Programme $programme
     *
     * @return void
     */
    public function update(Programme $programme): void
    {
        // Simulate a delay for a better user experience.
        sleep(2);

        // Trim the edited programme name to remove extra whitespace.
        $trimmedName = trim($this->editProgramme['name']);

        // If the trimmed name is the same as the current programme's name, reset the form values.
        if (strtolower($trimmedName) === strtolower($programme->name)) {
            $this->resetValues();
            return;
        }

        // Validate the trimmed name using Livewire validation rules.
        $this->validateOnly('editProgramme.name');

        // Store the old programme name for displaying success message.
        $oldName = $programme->name;

        // Update the programme's name with the trimmed value.
        $programme->update(['name' => $trimmedName]);

        // Reset form values.
        $this->resetValues();

        // Show a success toast message with the old and new programme names.
        $this->showToast('success', "The programme <b><i>{$oldName}</i></b> has been updated to <b><i>{$programme->name}</i></b>.");
    }

    /**
     * Initialize the form for adding a new course to a programme.
     *
     * @param Programme $programme
     *
     * @return void
     */
    public function newCourse(Programme $programme): void
    {
        // Reset the form fields.
        $this->form->reset();

        // Load the selected programme with its associated courses.
        $this->selectedProgramme = $programme->load('courses');

        // Reset any previous error messages.
        $this->resetErrorBag();

        // Display the modal for adding a new course.
        $this->showModal = true;
    }

    /**
     * Create a new course and associate it with the selected programme.
     *
     * @return void
     */
    public function createCourse(): void
    {
        // Set the programme ID for the new course.
        $this->form->programme_id = $this->selectedProgramme->id;

        // Create the new course using the form data.
        $this->form->create();

        // Show a success toast message with the name of the added course and its associated programme.
        $this->showToast('success', "The course <b><i>{$this->form->name}</i></b> has been added to the <b><i>{$this->selectedProgramme->name}</i></b> programme.");

        // Reset the form fields after successfully creating the course.
        $this->form->reset();
    }

    /**
     * Show a Swal toast with specified background and message.
     *
     * @param string $background
     * @param string $message
     *
     * @return void
     */
    private function showToast(string $background, string $message): void
    {
        // Dispatch a Livewire event to show a Swal toast with the provided background and message.
        $this->dispatch('swal:toast', [
            'background' => $background,
            'html' => $message,
        ]);
    }

    /**
     * Initiate the removal of a programme, prompting for confirmation.
     *
     * @param Programme $programme
     * @param int $coursesCount
     *
     * @return void
     */
    public function remove(Programme $programme, int $coursesCount): void
    {
        // Dispatch a Livewire event to show a Swal confirmation with parameters.
        $this->dispatch('swal:confirm', [
            'title' => "Delete $programme->name?",
            'icon' => $coursesCount > 0 ? 'warning' : '',
            'background' => $coursesCount > 0 ? 'error' : '',
            'html' => $coursesCount > 0 ?
                '<b>ATTENTION</b>: you are going to delete <b>' .
                $coursesCount . Str::plural(' course', $coursesCount) .
                '</b> at the same time!' : '',
            'color' => $coursesCount > 0 ? 'red' : '',
            'cancelButtonText' => 'NO!',
            'confirmButtonText' => 'YES DELETE THIS PROGRAMME',
            'next' => [
                'event' => 'delete',
                'params' => [
                    'id' => $programme->id
                ]
            ]
        ]);
    }

    /**
     * Delete a programme and show a success toast.
     *
     * @param int $id
     *
     * @return void
     */
    #[On('delete')]
    public function delete(int $id): void
    {
        // Retrieve the Programme with the specified ID or throw an exception if not found.
        $programme = Programme::findOrFail($id);

        // Delete the retrieved Programme.
        $programme->delete();

        // Show a success toast indicating that the programme has been deleted.
        $this->showToast('success', "The programme <b><i>{$programme->name}</i></b> has been deleted.");
    }

    //endregion
}
