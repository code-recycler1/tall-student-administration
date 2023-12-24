<?php

namespace App\Livewire\Admin;

use App\Models\Programme;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Programmes extends Component
{
    public $orderBy = 'name';
    public $orderAsc = true;

    public function resort($column): void
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    #[Layout('layouts.studentadministration', ['title' => 'Programmes', 'description' => 'Manage the programmes',])]
    public function render(): View
    {
        $allProgrammes = Programme::withCount('courses')->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->get();
        return view('livewire.admin.programmes', compact('allProgrammes'));
    }
}
