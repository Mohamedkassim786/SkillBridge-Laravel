<div class="min-h-screen pb-24" style="background-color: #0B1F3A; color: #cbd5e1;" x-data="{ annual: true }">

    <!-- TOP HERO SECTION -->
    <div style="background: linear-gradient(180deg, #0B1F3A 0%, #081628 100%); border-bottom: 1px solid #1e3a5f; padding: 24px 0 32px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="text-slate-600">></span>
                <span class="text-rose-400 font-bold">Pricing</span>
            </nav>

            <div class="text-center max-w-3xl mx-auto space-y-4">
                <h1 class="text-4xl font-black text-white tracking-tight">Choose the Perfect Plan for Your Needs</h1>
                <p class="text-slate-300 text-sm sm:text-base">
                    Start for free, upgrade as you grow. No hidden fees.
                </p>

                <!-- Billing Toggle Switch -->
                <div class="flex items-center justify-center gap-4 pt-3">
                    <span class="text-xs font-bold" :class="!annual ? 'text-white' : 'text-slate-400'">Monthly</span>
                    <button @click="annual = !annual" style="background: #112240; border: 1px solid #1e3a5f;" class="relative w-14 h-7 rounded-full transition-all focus:outline-none p-1">
                        <span style="background: #D62828;" class="block w-5 h-5 rounded-full transition-all duration-300 shadow-md" :class="annual ? 'translate-x-7' : 'translate-x-0'"></span>
                    </button>
                    <span class="text-xs font-bold flex items-center gap-2" :class="annual ? 'text-white' : 'text-slate-400'">
                        Annual
                        <span style="background: rgba(214,40,40,0.15); color: #f87171; border: 1px solid rgba(214,40,40,0.3);" class="px-2 py-0.5 rounded-full text-[10px] font-extrabold">Save 20%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- PRICING CARDS SECTION (4 Cards Horizontally) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">

            <!-- CARD 1: FREE PLAN -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 28px;" class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Free</span>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-4xl font-black text-white">₹0</span>
                            <span class="text-xs text-slate-400">/month</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">For individuals starting out</p>
                    </div>

                    <a href="{{ route('register') }}" style="background: transparent; border: 1px solid #1e3a5f; color: white;" class="block w-full py-3 rounded-xl font-extrabold text-xs text-center hover:bg-slate-800 transition-all">
                        Get Started Free
                    </a>

                    <div class="border-t border-slate-800 pt-4">
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Up to 50 students</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 3 courses</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Basic course builder</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 5 GB storage</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 5 hours live classes/mo</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Basic certificates</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 5% transaction fee</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Community support</li>
                        </ul>
                    </div>
                </div>

                <div class="text-[11px] text-slate-500 text-center pt-2">
                    No credit card required
                </div>
            </div>

            <!-- CARD 2: STARTER PLAN -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 28px;" class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-rose-400">Starter</span>
                        <span style="background: rgba(214,40,40,0.15); color: #f87171; border: 1px solid rgba(214,40,40,0.3);" class="px-2 py-0.5 rounded-full text-[10px] font-extrabold">Save 20%</span>
                    </div>

                    <div>
                        <div class="flex items-baseline gap-1 mt-1">
                            <span class="text-4xl font-black text-white" x-text="annual ? '₹1,999' : '₹2,499'">₹1,999</span>
                            <span class="text-xs text-slate-400">/month</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1" x-text="annual ? '₹23,988/year (Save ₹5,998)' : 'Billed monthly'">₹23,988/year</p>
                        <p class="text-xs text-slate-400 mt-1">For small training centers</p>
                    </div>

                    <a href="{{ route('register') }}" style="background: #1e3a5f; color: white;" class="block w-full py-3 rounded-xl font-extrabold text-xs text-center hover:bg-slate-700 transition-all">
                        Get Started
                    </a>

                    <div class="border-t border-slate-800 pt-4">
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Up to 200 students</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 20 courses</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Advanced course builder</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 50 GB storage</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 20 hours live classes/mo</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Branded certificates</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 2% transaction fee</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Email support (48hr)</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Custom domain</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Basic analytics</li>
                        </ul>
                    </div>
                </div>

                <div style="background: #081628; border: 1px solid #1e3a5f;" class="p-2 rounded-xl text-center text-[10.5px] font-bold text-slate-300">
                    Most popular for startups
                </div>
            </div>

            <!-- CARD 3: PROFESSIONAL PLAN (RECOMMENDED HIGHLIGHTED) -->
            <div style="background: #112240; border: 2px solid #D62828; border-radius: 24px; padding: 28px; box-shadow: 0 12px 40px rgba(214,40,40,0.25);" class="relative flex flex-col justify-between space-y-6 lg:-mt-3 lg:-mb-3">

                <!-- Recommended Badge Ribbon -->
                <div class="absolute -top-3.5 inset-x-0 flex justify-center">
                    <span style="background: #D62828; color: white;" class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg">
                        RECOMMENDED
                    </span>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-white">Professional</span>
                        <span style="background: #D62828; color: white;" class="px-2 py-0.5 rounded-full text-[10px] font-extrabold">Best Value</span>
                    </div>

                    <div>
                        <div class="flex items-baseline gap-1 mt-1">
                            <span class="text-4xl font-black text-[#f87171]" x-text="annual ? '₹5,999' : '₹7,499'">₹5,999</span>
                            <span class="text-xs text-slate-400">/month</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1" x-text="annual ? '₹71,988/year (Save ₹17,998)' : 'Billed monthly'">₹71,988/year</p>
                        <p class="text-xs text-slate-300 font-semibold mt-1">For growing businesses</p>
                    </div>

                    <a href="{{ route('register') }}" style="background: #D62828; color: white; box-shadow: 0 4px 16px rgba(214,40,40,0.4);" class="block w-full py-3.5 rounded-xl font-extrabold text-xs text-center hover:bg-red-700 transition-all">
                        Get Started ➔
                    </a>

                    <div class="border-t border-slate-800 pt-4">
                        <ul class="space-y-2.5 text-xs text-slate-200">
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> <strong>Up to 1,000 students</strong></li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> <strong>Unlimited courses</strong></li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Full builder + AI features</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 200 GB storage</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 100 hours live classes/mo</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Certificates + QR verification</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> <strong>0% transaction fee</strong></li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Priority support (24hr)</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Custom domain + SSL</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Advanced analytics & reports</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Job portal access</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> AI resume review (50/mo)</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> API access</li>
                        </ul>
                    </div>
                </div>

                <div style="background: rgba(214,40,40,0.15); color: #f87171; border: 1px solid rgba(214,40,40,0.3);" class="p-2 rounded-xl text-center text-[10.5px] font-extrabold">
                    Recommended for growth
                </div>
            </div>

            <!-- CARD 4: ENTERPRISE PLAN -->
            <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 24px; padding: 28px;" class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Enterprise</span>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-3xl font-black text-white">Custom</span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1">For large organizations</p>
                    </div>

                    <a href="{{ route('contact') }}" style="background: transparent; border: 1px solid #1e3a5f; color: white;" class="block w-full py-3 rounded-xl font-extrabold text-xs text-center hover:bg-slate-800 transition-all">
                        Contact Sales
                    </a>

                    <div class="border-t border-slate-800 pt-4">
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Unlimited students</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Unlimited courses & classes</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> 1 TB+ storage</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> White-label platform</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Dedicated account manager</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> SSO & SAML integration</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Multi-domain support</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> SLA guarantee (99.9%)</li>
                            <li class="flex items-center gap-2"><svg style="width: 12px; height: 12px; min-width: 12px;" class="text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> On-premise option</li>
                        </ul>
                    </div>
                </div>

                <div class="text-[11px] text-slate-500 text-center pt-2">
                    Custom SLAs & deployment
                </div>
            </div>

        </div>
    </div>



    <!-- FAQ SECTION (Accordion) -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-slate-800 space-y-8">
        <div class="text-center space-y-2">
            <span class="text-xs font-bold text-[#D62828] uppercase tracking-widest">Questions & Answers</span>
            <h2 class="text-3xl font-black text-white">Frequently Asked Questions</h2>
        </div>

        @php
            $pricingFaqs = [
                ['q' => 'Can I change plans later?', 'a' => 'Yes, you can upgrade, downgrade, or switch between monthly and annual billing cycles at any time from your account dashboard.'],
                ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit cards, debit cards, UPI, Net Banking, and corporate invoicing for Enterprise plans.'],
                ['q' => 'Is there a refund policy?', 'a' => 'Yes, all paid plans come with a 30-day 100% money-back guarantee. No questions asked.'],
                ['q' => 'Do you offer discounts for nonprofits?', 'a' => 'Yes, we offer special non-profit and educational institution discounts. Contact our sales team for verification.'],
                ['q' => 'Can I cancel anytime?', 'a' => 'Absolutely. You can cancel your subscription at any time without extra cancellation fees.'],
                ['q' => 'How does the transaction fee work?', 'a' => 'Transaction fees are deducted automatically on sales made through the platform gateway based on your tier (5% on Free, 2% on Starter, 0% on Professional).'],
            ];
        @endphp

        <div class="space-y-3" x-data="{ openFaq: 0 }">
            @foreach ($pricingFaqs as $fIdx => $fItem)
                <div style="background: #112240; border: 1px solid #1e3a5f; border-radius: 16px;" class="overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $fIdx }} ? null : {{ $fIdx }}" class="w-full p-4 text-left font-bold text-xs sm:text-sm text-white flex items-center justify-between">
                        <span>{{ $fItem['q'] }}</span>
                        <svg class="w-4 h-4 text-rose-400 transition-transform shrink-0" :class="openFaq === {{ $fIdx }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="openFaq === {{ $fIdx }}" x-cloak class="p-4 pt-0 text-xs text-slate-300 leading-relaxed border-t border-slate-800">
                        {{ $fItem['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- BOTTOM CTA SECTION -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <div style="background: linear-gradient(135deg, #112240 0%, #081628 100%); border: 1px solid #1e3a5f; border-radius: 28px; padding: 48px 32px; text-align: center; box-shadow: 0 12px 40px rgba(0,0,0,0.4);" class="space-y-6 max-w-4xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Still Have Questions?
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto leading-relaxed">
                Talk to our sales team to find the perfect plan for your business or get a custom Enterprise demo.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2">
                <a href="{{ route('contact') }}" style="background: #D62828; color: white; font-weight: 800; font-size: 13px; padding: 12px 28px; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 16px rgba(214,40,40,0.4);">
                    Contact Sales ➔
                </a>
                <a href="{{ route('courses.index') }}" style="background: transparent; border: 1px solid #1e3a5f; color: white; font-weight: 700; font-size: 13px; padding: 12px 28px; border-radius: 12px; text-decoration: none;" onmouseover="this.style.background='rgba(255,255,255,0.07)';" onmouseout="this.style.background='transparent';">
                    View Demo
                </a>
            </div>
        </div>
    </div>

</div>
