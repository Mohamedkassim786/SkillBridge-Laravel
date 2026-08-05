<?php

namespace App\Livewire\Public;

use App\Models\Faq;
use App\Models\PricingPlan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Pricing Plans - SkillBridge LMS')]
class Pricing extends Component
{
    public bool $isYearly = true;

    public function render()
    {
        $plans = PricingPlan::orderBy('sort_order')->get();
        $faqs = Faq::where('category', 'Pricing')->orWhere('is_published', true)->take(4)->get();

        return view('livewire.public.pricing', compact('plans', 'faqs'));
    }
}
