<?php

namespace App\Livewire\Public;

use App\Models\CmsSetting;
use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.public')]
#[Title('Contact Us - SkillBridge LMS')]
class Contact extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $subject = '';
    public string $message = '';
    public bool $submitted = false;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'status' => 'unread',
        ]);

        $this->submitted = true;
        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
    }

    public function render()
    {
        $sitePhone = CmsSetting::get('site_phone', '+1 (800) 555-SKILL');
        $siteEmail = CmsSetting::get('site_email', 'support@skillbridge.io');
        $siteAddress = CmsSetting::get('site_address', '100 Silicon Valley Way, Suite 400, San Francisco, CA');

        return view('livewire.public.contact', compact('sitePhone', 'siteEmail', 'siteAddress'));
    }
}
