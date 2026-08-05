<div class="min-h-screen pb-24 relative" style="background-color: #0B1F3A; color: #cbd5e1;" x-data="{ termsAgreed: true, openFaq: 0, showChatModal: false }">

    <!-- TOP HERO SECTION -->
    <div style="background: linear-gradient(180deg, #0B1F3A 0%, #081628 100%); border-bottom: 1px solid #1e3a5f; padding: 24px 0 32px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-slate-600">></span>
                <span class="text-rose-400 font-bold">Contact</span>
            </nav>

            <div class="text-center max-w-3xl mx-auto space-y-4">
                <h1 class="text-4xl font-black text-white tracking-tight">Get in Touch</h1>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN LAYOUT (60% Left, 40% Right) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT COLUMN: Contact Form (60% Width = 7 cols) -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 32px;" class="lg:col-span-7 space-y-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-white">Send us a Message</h2>
                    <p class="text-xs text-slate-400">Fill in the form below to reach our dedicated support engineering team.</p>
                </div>

                @if ($submitted)
                    <div style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #34d399;" class="p-4 rounded-2xl text-xs font-bold flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <div>
                            <div>Message sent successfully!</div>
                            <div class="text-[11px] font-normal opacity-90 mt-0.5">Thank you for reaching out. We usually respond within 24 hours.</div>
                        </div>
                    </div>
                @endif

                <form wire:submit.prevent="submit" class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="name" required placeholder="John Doe" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-slate-500 focus:outline-none focus:border-rose-500">
                        @error('name') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email Address & Phone Number -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" wire:model="email" required placeholder="john@example.com" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-slate-500 focus:outline-none focus:border-rose-500">
                            @error('email') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Phone Number</label>
                            <input type="tel" wire:model="phone" placeholder="+91 98765 43210" style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-slate-500 focus:outline-none focus:border-rose-500">
                        </div>
                    </div>

                    <!-- Subject Dropdown -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Subject <span class="text-rose-500">*</span></label>
                        <select wire:model="subject" required style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs focus:outline-none focus:border-rose-500">
                            <option value="">Select a subject...</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Course Support">Course Support</option>
                            <option value="Job Support">Job Support</option>
                            <option value="Payment Issue">Payment Issue</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('subject') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Message Textarea -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Message <span class="text-rose-500">*</span></label>
                        <textarea wire:model="message" rows="5" required placeholder="Your message..." style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-4 py-3 rounded-xl text-xs placeholder-slate-500 focus:outline-none focus:border-rose-500 resize-none"></textarea>
                        @error('message') <span class="text-[11px] text-rose-400 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- File Upload Attachment (Optional) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">Attachment (Optional, for screenshots)</label>
                        <input type="file" style="background: #081628; border: 1px solid #1e3a5f; color: #94a3b8;" class="w-full px-4 py-2.5 rounded-xl text-xs file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#1e3a5f] file:text-white cursor-pointer">
                    </div>

                    <!-- Terms & Conditions Checkbox -->
                    <div class="flex items-center gap-2.5 pt-1">
                        <input type="checkbox" x-model="termsAgreed" id="termsCheck" style="accent-color: #D62828;" class="w-4 h-4 rounded">
                        <label for="termsCheck" class="text-xs text-slate-300 font-medium cursor-pointer">
                            I agree to the <a href="#" class="text-rose-400 hover:underline font-bold">Terms & Conditions</a> and Privacy Policy.
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" :disabled="!termsAgreed" style="background: #D62828; color: white; box-shadow: 0 4px 16px rgba(214,40,40,0.4);" class="w-full py-3.5 rounded-xl font-extrabold text-xs tracking-wider uppercase hover:bg-red-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            Send Message ➔
                        </button>
                        <p class="text-[11px] text-slate-500 text-center font-medium mt-2.5">
                            We usually respond within 24 hours.
                        </p>
                    </div>
                </form>
            </div>

            <!-- RIGHT COLUMN: Contact Information Cards (40% Width = 5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                <div class="space-y-1">
                    <h2 class="text-2xl font-black text-white">Contact Information</h2>
                    <p class="text-xs text-slate-400">Reach out to us directly through any of our channels.</p>
                </div>

                <div class="space-y-4">

                    <!-- Card 1: Phone -->
                    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;" class="flex items-start gap-4">
                        <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(214,40,40,0.15); border: 1px solid rgba(214,40,40,0.3); color: #f87171;" class="flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Phone</div>
                            <div class="text-sm font-extrabold text-white mt-0.5">+91 98765 43210</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Mon-Fri, 9am-6pm IST</div>
                        </div>
                    </div>

                    <!-- Card 2: Email -->
                    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;" class="flex items-start gap-4">
                        <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(214,40,40,0.15); border: 1px solid rgba(214,40,40,0.3); color: #f87171;" class="flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email</div>
                            <div class="text-sm font-extrabold text-white mt-0.5">support@skillplace.com</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">We'll reply within 24 hours</div>
                        </div>
                    </div>

                    <!-- Card 3: Office Location -->
                    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;" class="flex items-start gap-4">
                        <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(214,40,40,0.15); border: 1px solid rgba(214,40,40,0.3); color: #f87171;" class="flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Office</div>
                            <div class="text-xs font-extrabold text-white mt-0.5 leading-snug">123, Tech Park, Anna Nagar, Chennai, Tamil Nadu 600040</div>
                            <div class="text-[11px] text-slate-400 mt-0.5">Visit us during business hours</div>
                        </div>
                    </div>

                    <!-- Card 4: Social Media -->
                    <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; padding: 24px;" class="flex items-start gap-4">
                        <div style="width: 44px; height: 44px; border-radius: 14px; background: rgba(214,40,40,0.15); border: 1px solid rgba(214,40,40,0.3); color: #f87171;" class="flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <div class="space-y-1.5 flex-1">
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Social Media</div>
                            <div class="flex items-center gap-3 pt-1">
                                <a href="#" title="LinkedIn" style="background: #081628; border: 1px solid #1e3a5f; color: #60a5fa;" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold hover:border-rose-500 transition-all">in</a>
                                <a href="#" title="Twitter" style="background: #081628; border: 1px solid #1e3a5f; color: #38bdf8;" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold hover:border-rose-500 transition-all">X</a>
                                <a href="#" title="Facebook" style="background: #081628; border: 1px solid #1e3a5f; color: #3b82f6;" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold hover:border-rose-500 transition-all">fb</a>
                                <a href="#" title="Instagram" style="background: #081628; border: 1px solid #1e3a5f; color: #f43f5e;" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold hover:border-rose-500 transition-all">ig</a>
                                <a href="#" title="YouTube" style="background: #081628; border: 1px solid #1e3a5f; color: #ef4444;" class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-extrabold hover:border-rose-500 transition-all">yt</a>
                            </div>
                            <div class="text-[11px] text-slate-400 pt-0.5">Follow us for real-time updates</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- GOOGLE MAPS LOCATION SECTION (Full Width, 400px Height) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; overflow: hidden;" class="space-y-0">
            <div class="p-4 border-b border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs font-bold text-white">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Office Location: 123 Tech Park, Anna Nagar, Chennai
                </div>
                <a href="https://maps.google.com/?q=Anna+Nagar+Chennai" target="_blank" style="color: #f87171;" class="text-xs font-bold hover:underline flex items-center gap-1">
                    View on Google Maps ➔
                </a>
            </div>

            <!-- Styled Map Container -->
            <div style="height: 360px; background: linear-gradient(135deg, #081628 0%, #050E1A 100%); position: relative;" class="flex items-center justify-center text-center p-8">
                <div style="position: absolute; inset: 0; opacity: 0.15; background-image: radial-gradient(#38bdf8 1px, transparent 1px); background-size: 20px 20px;"></div>
                
                <div class="relative z-10 space-y-3 max-w-md">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #D62828; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 0 30px rgba(214,40,40,0.6);" class="animate-bounce">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-white">SkillBridge Corporate Headquarters</h3>
                    <p class="text-xs text-slate-300">123, Tech Park, Anna Nagar, Chennai, Tamil Nadu 600040</p>
                    <a href="https://maps.google.com/?q=Anna+Nagar+Chennai" target="_blank" style="background: #D62828; color: white; text-decoration: none;" class="inline-block px-5 py-2 rounded-xl text-xs font-bold hover:bg-red-700 transition-all shadow-md mt-2">
                        Open Navigation Maps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ SECTION (Accordion) -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-slate-800 space-y-8">
        <div class="text-center space-y-2">
            <span class="text-xs font-bold text-[#D62828] uppercase tracking-widest">Common Enquiries</span>
            <h2 class="text-3xl font-black text-white">Frequently Asked Questions</h2>
        </div>

        @php
            $contactFaqs = [
                ['q' => 'How do I enroll in a course?', 'a' => 'Simply browse our courses catalog, select your desired module, click "Enroll Now", and complete the instant registration process.'],
                ['q' => 'What is your refund policy?', 'a' => 'We offer a 30-day money-back guarantee on all courses. If you are not satisfied, contact support within 30 days for a full refund.'],
                ['q' => 'How do I apply for jobs?', 'a' => 'Navigate to the Job Board, filter by your stack and experience level, and click "Apply Now" to submit your profile directly to hiring partners.'],
                ['q' => 'How do I contact my instructor?', 'a' => 'Once enrolled, you can reach your instructor through the course discussion forums or live weekly Q&A sessions.'],
                ['q' => 'Do you offer corporate training?', 'a' => 'Yes, we provide custom enterprise training packages with bulk student licensing, custom curricula, and SLA support.'],
                ['q' => 'How do I become a trainer?', 'a' => 'Select "Partnership" in the contact form subject dropdown above and attach your resume/portfolio to apply as an instructor.'],
            ];
        @endphp

        <div class="space-y-3">
            @foreach ($contactFaqs as $cFIdx => $cFItem)
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px;" class="overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $cFIdx }} ? null : {{ $cFIdx }}" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-white flex items-center justify-between">
                        <span>{{ $cFItem['q'] }}</span>
                        <svg class="w-4 h-4 text-rose-400 transition-transform shrink-0" :class="openFaq === {{ $cFIdx }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openFaq === {{ $cFIdx }}" x-cloak class="p-4 pt-0 text-xs text-slate-300 leading-relaxed border-t border-slate-800">
                        {{ $cFItem['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- LIVE CHAT WIDGET (Bottom Right Corner) -->
    <div style="position: fixed; bottom: 28px; right: 28px; z-index: 50;">
        <button @click="showChatModal = !showChatModal" style="background: #D62828; color: white; box-shadow: 0 8px 30px rgba(214,40,40,0.5);" class="flex items-center gap-2.5 px-4 py-3 rounded-full font-extrabold text-xs shadow-2xl hover:bg-red-700 transition-all cursor-pointer">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
            </span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <span>Chat with us</span>
            <span style="background: rgba(255,255,255,0.2);" class="px-2 py-0.5 rounded-full text-[9.5px] font-extrabold uppercase">We're online!</span>
        </button>

        <!-- Popup Chat Box Modal -->
        <div x-show="showChatModal" x-cloak style="background: #112240; border: 1px solid #1e3a5f; border-radius: 20px; width: 320px; box-shadow: 0 20px 50px rgba(0,0,0,0.6);" class="absolute bottom-16 right-0 p-4 space-y-3">
            <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                <div class="flex items-center gap-2 text-xs font-bold text-white">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Support Agent
                </div>
                <button @click="showChatModal = false" class="text-slate-400 hover:text-white text-xs font-bold">✕</button>
            </div>
            <div class="text-xs text-slate-300 space-y-2">
                <div style="background: #081628;" class="p-3 rounded-xl border border-slate-800">
                    Hello! 👋 Welcome to SkillBridge. How can we help you today?
                </div>
            </div>
            <div class="flex gap-2 pt-1">
                <input type="text" placeholder="Type a message..." style="background: #081628; border: 1px solid #1e3a5f; color: white;" class="w-full px-3 py-2 rounded-xl text-xs outline-none">
                <button style="background: #D62828; color: white;" class="px-3 py-2 rounded-xl text-xs font-bold hover:bg-red-700">Send</button>
            </div>
        </div>
    </div>

</div>
