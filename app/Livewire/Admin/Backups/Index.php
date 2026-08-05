<?php

namespace App\Livewire\Admin\Backups;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Database & System Backups - Admin Portal')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.backups.index');
    }
}
