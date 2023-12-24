<?php

namespace App\Livewire\Admin;

use App\Models\Programme;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Programmes extends Component
{
    public $orderBy = 'name';
    public $orderAsc = true;

    #[Validate(
        'required|min:3|max:30|unique:programmes,name',
        attribute: 'name for this programme',
    )]
    public $newProgramme;

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
        $this->reset('newProgramme');
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
}
