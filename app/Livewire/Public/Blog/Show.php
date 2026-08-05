<?php

namespace App\Livewire\Public\Blog;

use App\Models\BlogPost;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Blog Article - SkillBridge LMS')]
class Show extends Component
{
    public string $slug;

    public function mount(string $slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $post = BlogPost::where('slug', $this->slug)->firstOrFail();
        $post->increment('views_count');

        return view('livewire.public.blog.show', compact('post'));
    }
}
