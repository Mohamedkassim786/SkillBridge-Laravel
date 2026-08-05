<?php

namespace App\Livewire\Admin\Applications;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Job Applications Management - Admin Portal')]
class Manage extends Component
{
    public function render()
    {
        return view('livewire.admin.applications.manage');
    }
}
