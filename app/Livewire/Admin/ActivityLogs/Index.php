<?php

namespace App\Livewire\Admin\ActivityLogs;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Audit & Activity Logs - Admin Portal')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.activity-logs.index');
    }
}
