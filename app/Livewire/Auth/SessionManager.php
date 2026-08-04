<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.auth')]
#[Title('Session Management - SkillBridge')]
class SessionManager extends Component
{
    public string $password = '';

    public function logoutOtherDevices()
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        Auth::logoutOtherDevices($this->password);

        $this->reset('password');
        session()->flash('status', 'All other browser sessions have been logged out.');
    }

    public function deleteSession(string $sessionId)
    {
        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->delete();

        session()->flash('status', 'Session terminated successfully.');
    }

    public function getSessionsProperty()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === session()->getId(),
                    'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'user_agent' => $session->user_agent,
                ];
            });
    }

    public function render()
    {
        return view('livewire.auth.session-manager');
    }
}
