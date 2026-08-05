<?php

namespace App\Livewire\Public\Blog;

use App\Models\BlogPost;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Engineering Blog - SkillBridge LMS')]
class Index extends Component
{
    public function render()
    {
        $posts = BlogPost::where('is_published', true)->orderBy('created_at', 'desc')->get();

        return view('livewire.public.blog.index', compact('posts'));
    }
}
