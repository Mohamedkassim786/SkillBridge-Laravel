<?php

namespace App\Livewire\Admin\Cms;

use App\Models\CmsSetting;
use App\Models\Faq;
use App\Models\PricingPlan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Admin CMS Control Panel - SkillBridge')]
class Manage extends Component
{
    public string $activeTab = 'hero';

    // Hero & Site inputs
    public string $hero_headline = '';
    public string $hero_subheading = '';
    public string $site_name = '';
    public string $site_phone = '';
    public string $site_email = '';
    public string $site_address = '';

    // FAQ inputs
    public string $new_faq_question = '';
    public string $new_faq_answer = '';
    public string $new_faq_category = 'General';

    public function mount()
    {
        $user = auth()->user();
        if (! $user || ! in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized access to Admin CMS.');
        }

        $this->hero_headline = CmsSetting::get('hero_headline', 'Master Enterprise Software Engineering with Real Code');
        $this->hero_subheading = CmsSetting::get('hero_subheading', 'Learn full-stack software architecture, domain-driven design, microservices, and modern PHP/Laravel.');
        $this->site_name = CmsSetting::get('site_name', 'SkillBridge LMS');
        $this->site_phone = CmsSetting::get('site_phone', '+1 (800) 555-SKILL');
        $this->site_email = CmsSetting::get('site_email', 'support@skillbridge.io');
        $this->site_address = CmsSetting::get('site_address', '100 Silicon Valley Way, Suite 400, San Francisco, CA');
    }

    public function saveSettings()
    {
        CmsSetting::set('hero_headline', $this->hero_headline);
        CmsSetting::set('hero_subheading', $this->hero_subheading);
        CmsSetting::set('site_name', $this->site_name);
        CmsSetting::set('site_phone', $this->site_phone);
        CmsSetting::set('site_email', $this->site_email);
        CmsSetting::set('site_address', $this->site_address);

        session()->flash('status', 'CMS & Site Settings updated successfully! All public pages updated instantly.');
    }

    public function addFaq()
    {
        $this->validate([
            'new_faq_question' => 'required|string|max:255',
            'new_faq_answer' => 'required|string|min:5',
        ]);

        Faq::create([
            'question' => $this->new_faq_question,
            'answer' => $this->new_faq_answer,
            'category' => $this->new_faq_category,
            'is_published' => true,
        ]);

        $this->reset(['new_faq_question', 'new_faq_answer']);
        session()->flash('status', 'New FAQ added successfully!');
    }

    public function deleteFaq(string $id)
    {
        $faq = Faq::find($id);
        if ($faq) {
            $faq->delete();
            session()->flash('status', 'FAQ deleted successfully.');
        }
    }

    public function render()
    {
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        $pricingPlans = PricingPlan::orderBy('sort_order')->get();

        return view('livewire.admin.cms.manage', [
            'faqs' => $faqs,
            'pricingPlans' => $pricingPlans,
        ]);
    }
}
