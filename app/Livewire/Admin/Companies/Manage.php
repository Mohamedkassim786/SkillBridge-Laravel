<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.admin')]
#[Title('Hiring Companies Management - Admin Portal')]
class Manage extends Component
{
    public function render()
    {
        $companies = Company::paginate(10);
        return view('livewire.admin.companies.manage', compact('companies'));
    }
}
