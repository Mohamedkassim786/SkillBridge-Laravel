<?php

namespace App\Livewire\Public;

use App\Models\Faq as FaqModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('FAQ - Frequently Asked Questions')]
class Faq extends Component
{
    public string $search = '';

    public function render()
    {
        $query = FaqModel::where('is_published', true);

        if ($this->search) {
            $query->where('question', 'like', '%' . $this->search . '%')
                  ->orWhere('answer', 'like', '%' . $this->search . '%');
        }

        $faqs = $query->orderBy('sort_order')->get();

        return view('livewire.public.faq', compact('faqs'));
    }
}
