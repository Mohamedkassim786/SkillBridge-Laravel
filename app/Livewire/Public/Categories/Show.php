<?php

namespace App\Livewire\Public\Categories;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Category Details - SkillBridge LMS')]
class Show extends Component
{
    public string $slug;

    public function mount(string $slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $category = Category::where('slug', $this->slug)->firstOrFail();
        $courses = $category->courses()->with(['currentVersion', 'trainer'])->get();

        return view('livewire.public.categories.show', [
            'category' => $category,
            'courses' => $courses,
        ]);
    }
}
