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
            // Set the default avatar using the user's name.
            $this->avatar = 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name);

            // Check if the user has a custom profile photo.
            if (auth()->user()->profile_photo_path) {
                // Check if the photo file exists in the public storage.
                if (Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                    // Set the avatar to the custom profile photo.
                    $this->avatar = asset('storage/' . auth()->user()->profile_photo_path);
            }
        }
        return view('livewire.layout.navigation');
    }
}
