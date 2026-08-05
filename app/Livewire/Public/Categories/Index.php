<?php

namespace App\Livewire\Public\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Categories - SkillBridge LMS')]
class Index extends Component
{
    public function render()
    {
        $categories = Category::withCount('courses')->get();

        return view('livewire.public.categories.index', compact('categories'));
    }
}
