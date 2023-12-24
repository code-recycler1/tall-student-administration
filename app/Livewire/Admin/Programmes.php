<?php

namespace App\Livewire\Admin;

use App\Models\Programme;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Str;

class Programmes extends Component
{
    public $orderBy = 'name';
    public $orderAsc = true;

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
            ->get();
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
        $this->reset('newProgramme', 'editProgramme');
        $this->resetErrorBag();
    }

    public function create(): void
    {
        $this->validateOnly('newProgramme');

        $programme = Programme::create([
            'name' => trim($this->newProgramme),
        ]);

        $this->resetValues();

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "The programme <b><i>{$programme->name}</i></b> has been added.",
        ]);
    }

    public function edit(Programme $programme): void
    {
        $this->editProgramme = [
            'id' => $programme->id,
            'name' => $programme->name,
        ];
    }

    public function update(Programme $programme): void
    {
        sleep(2);

        $this->validateOnly('editProgramme.name');
        $oldName = $programme->name;
        $programme->update([
            'name' => trim($this->editProgramme['name']),
        ]);
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "The programme <b><i>{$oldName}</i></b> has been updated to <b><i>{$programme->name}</i></b>.",
        ]);
    }

    public function remove(Programme $programme, $coursesCount): void
    {
        $this->dispatch('swal:confirm', [
            'title' => "Delete $programme->name?",
            'icon' => $coursesCount > 0 ? 'warning' : '',
            'background' => $coursesCount > 0 ? 'error' : '',
            'html' => $coursesCount > 0 ?
                '<b>ATTENTION</b>: you are going to delete <b>' . $coursesCount . Str::plural(' course', $coursesCount) . '</b> at the same time!' : '', 'color' => $coursesCount > 0 ? 'red' : '',
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
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "The programme <b><i>{$programme->name}</i></b> has been deleted.",
        ]);
    }
}
