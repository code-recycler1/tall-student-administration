<?php

namespace App\Livewire\Layout;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Storage;

class Navigation extends Component
{
    public $avatar;

    #[On('refresh-navigation-menu')]
    public function render(): View
    {
        if (auth()->user()) {
            $this->avatar = 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name);
            if (auth()->user()->profile_photo_path) {
                if (Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                    $this->avatar = asset('storage/' . auth()->user()->profile_photo_path);
            }
        }
        return view('livewire.layout.navigation');
    }
}
