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

    #[Layout('layouts.studentadministration', ['title' => 'Programmes', 'description' => 'Manage the programmes',])]
    public function render(): View
    {
        $allProgrammes = Programme::withCount('courses')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.programmes', compact('allProgrammes'));
    }

    public function resort($column): void
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    public function resetValues(): void
    {
        $this->reset(['newProgramme', 'editProgramme']);
        $this->resetErrorBag();
    }

    public function create(): void
    {
        $this->validateOnly('newProgramme');

        $programme = Programme::create(['name' => trim($this->newProgramme)]);
        $this->resetValues();

        $this->showToast("The programme <b><i>{$programme->name}</i></b> has been added.");
    }

    public function edit(Programme $programme): void
    {
        $this->editProgramme = ['id' => $programme->id, 'name' => $programme->name];
    }

    public function update(Programme $programme): void
    {
        sleep(2);

        $this->editProgramme['name'] = trim($this->editProgramme['name']);
        if (strtolower($this->editProgramme['name']) === strtolower($programme->name)) {
            $this->resetValues();
            return;
        }

        $this->validateOnly('editProgramme.name');
        $oldName = $programme->name;
        $programme->update(['name' => trim($this->editProgramme['name'])]);
        $this->resetValues();

        $this->showToast("The programme <b><i>{$oldName}</i></b> has been updated to <b><i>{$programme->name}</i></b>.");
    }

    public function newCourse(Programme $programme): void
    {
        $this->form->reset();
        $this->selectedProgramme = $programme->load('courses');
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createCourse(): void
    {
        $this->form->programme_id = $this->selectedProgramme->id;
        $this->form->create();
        $this->showToast("The course <b><i>{$this->form->name}</i></b> has been added to the <b><i>{$this->selectedProgramme->name}</i></b> programme.");
        $this->form->reset();
    }

    private function showToast(string $message): void
    {
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => $message,
        ]);
    }

    public function remove(Programme $programme, int $coursesCount): void
    {
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

    #[On('delete')]
    public function delete(int $id): void
    {
        $programme = Programme::findOrFail($id);
        $programme->delete();

        $this->showToast("The programme <b><i>{$programme->name}</i></b> has been deleted.");
    }
}
