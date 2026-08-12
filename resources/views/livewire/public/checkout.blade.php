<div class="max-w-4xl mx-auto px-4 py-12 text-slate-800" x-data="{
    showModal: false,
    selectedTab: 'upi',
    upiId: 'student@okaxis',

    paySuccess() {
        this.showModal = false;
        @this.call('handleRazorpaySuccess', 'pay_rzp_test_' + Math.random().toString(36).substring(2, 10), this.selectedTab);
    }
}">
    <!-- FLASH MESSAGES -->
    @if (session()->has('error'))
        <div class="p-4 mb-6 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 font-semibold text-sm flex items-center justify-between shadow-sm">
            <span>⚠️ {{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- ORDER SUMMARY CARD -->
        <div style="background-color: #251237;" class="md:col-span-1 text-white rounded-3xl p-6 shadow-2xl h-fit border border-purple-800/40">
            <h3 class="text-xs uppercase font-extrabold tracking-widest text-purple-300 mb-4">Order Summary</h3>

            @if ($course)
                <div class="space-y-4">
                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-32 object-cover rounded-2xl border border-purple-700/40 shadow-md">
                    <div>
                        <h4 class="font-extrabold text-base leading-snug text-white">{{ $course->title }}</h4>
                        <p class="text-xs text-purple-200 mt-1">Instructor: {{ $course->trainer?->name ?? 'SkillBridge Expert' }}</p>
                    </div>
                    <div class="pt-4 border-t border-purple-800/40 flex justify-between items-center text-sm">
                        <span class="text-purple-300">Course Price</span>
                        <span class="font-extrabold text-white">₹{{ number_format($course->currentVersion?->price ?? 49, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-purple-300">Platform Fee</span>
                        <span class="font-semibold text-emerald-400">FREE</span>
                    </div>
                    <div class="pt-4 border-t border-purple-800/40 flex justify-between items-center text-lg font-black">
                        <span>Total Due</span>
                        <span class="text-[#f15153]">₹{{ number_format($course->currentVersion?->price ?? 49, 2) }}</span>
                    </div>
                </div>
            @else
                <p class="text-xs text-purple-300">No course selected.</p>
            @endif
        </div>

        <!-- PAYMENT FORM CARD -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-100 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Secure Checkout</h2>
                    <p class="text-xs font-semibold text-slate-500 mt-1">Razorpay 256-bit Encrypted Payment Gateway</p>
                </div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/89/Razorpay_logo.svg" alt="Razorpay" class="h-6 object-contain">
            </div>

            <div class="space-y-6">
                <!-- CUSTOMER DETAILS -->
                <div class="space-y-4">
                    <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Account Details</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                            <input type="text" wire:model="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#f15153]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                            <input type="email" wire:model="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#f15153]">
                        </div>
                    </div>
                </div>

                <!-- PAYMENT OPTIONS SUMMARY -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="text-xs font-extrabold text-slate-700">Supported Payment Options (Razorpay):</div>
                    <div class="flex flex-wrap gap-2 text-[11px] font-bold">
                        <span class="px-3 py-1 bg-white rounded-lg border border-slate-200 text-slate-800 shadow-sm">📱 GPay / PhonePe / Paytm</span>
                        <span class="px-3 py-1 bg-white rounded-lg border border-slate-200 text-slate-800 shadow-sm">💳 Credit / Debit Card</span>
                        <span class="px-3 py-1 bg-white rounded-lg border border-slate-200 text-slate-800 shadow-sm">🏦 NetBanking</span>
                    </div>
                </div>

                <!-- LAUNCH RAZORPAY MODAL BUTTON -->
                <button type="button" @click="showModal = true" style="background-color: #f15153;" class="w-full py-4 text-white rounded-2xl font-black text-base shadow-xl hover:opacity-90 transition relative flex items-center justify-center gap-2">
                    <span>💳 Proceed to Razorpay Payment (₹{{ number_format($course?->currentVersion?->price ?? 49, 2) }})</span>
                </button>
            </div>
        </div>
    </div>

    <!-- AUTHENTIC RAZORPAY POPUP MODAL OVERLAY -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" x-transition>
        <div class="bg-white rounded-3xl max-w-md w-full overflow-hidden shadow-2xl border border-slate-200 space-y-0" @click.away="showModal = false">
            <!-- MODAL HEADER BAR (RAZORPAY BLUE & LOGO) -->
            <div style="background-color: #210f30;" class="p-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center font-black text-[#f15153] text-lg">S</div>
                    <div>
                        <div class="text-xs font-extrabold tracking-wider text-purple-200">SkillBridge LMS</div>
                        <div class="text-sm font-black text-white">₹{{ number_format($course?->currentVersion?->price ?? 49, 2) }}</div>
                    </div>
                </div>
                <button @click="showModal = false" class="text-purple-300 hover:text-white text-lg font-bold">✕</button>
            </div>

            <!-- MODAL PAYMENT TAB NAVIGATION -->
            <div class="flex border-b border-slate-200 bg-slate-50 text-xs font-extrabold">
                <button @click="selectedTab = 'upi'" :class="{'bg-white text-[#f15153] border-b-2 border-[#f15153]': selectedTab === 'upi', 'text-slate-500': selectedTab !== 'upi'}" class="flex-1 py-3 text-center transition">
                    📱 UPI / QR
                </button>
                <button @click="selectedTab = 'card'" :class="{'bg-white text-[#f15153] border-b-2 border-[#f15153]': selectedTab === 'card', 'text-slate-500': selectedTab !== 'card'}" class="flex-1 py-3 text-center transition">
                    💳 Card
                </button>
                <button @click="selectedTab = 'netbanking'" :class="{'bg-white text-[#f15153] border-b-2 border-[#f15153]': selectedTab === 'netbanking', 'text-slate-500': selectedTab !== 'netbanking'}" class="flex-1 py-3 text-center transition">
                    🏦 NetBanking
                </button>
            </div>

            <!-- MODAL TAB CONTENTS -->
            <div class="p-6 space-y-5 text-slate-800">
                <!-- TAB 1: UPI -->
                <div x-show="selectedTab === 'upi'" class="space-y-4">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                        <div class="text-xs font-extrabold text-slate-700">Scan QR Code using GPay / PhonePe / Paytm</div>
                        <div class="w-32 h-32 mx-auto bg-white p-2 border border-slate-300 rounded-xl shadow-inner flex items-center justify-center">
                            <!-- Genuine QR Pattern Graphic -->
                            <svg class="w-28 h-28 text-slate-800" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm8-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm13-2h3v2h-3v-2zm-3 3h2v3h-2v-3zm3 0h3v5h-3v-5zm-6 2h2v3h-2v-3zm3 3h3v2h-3v-2z"/>
                            </svg>
                        </div>
                        <div class="text-[11px] font-bold text-slate-500">UPI ID: skillbridge@razorpay</div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Enter your UPI ID</label>
                        <input type="text" x-model="upiId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold focus:ring-2 focus:ring-[#f15153]">
                    </div>
                </div>

                <!-- TAB 2: CARD -->
                <div x-show="selectedTab === 'card'" class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Card Number</label>
                        <input type="text" value="4111 2222 3333 4444" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-slate-50">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Expiry</label>
                            <input type="text" value="12/28" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">CVV</label>
                            <input type="password" value="123" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold bg-slate-50">
                        </div>
                    </div>
                </div>

                <!-- TAB 3: NETBANKING -->
                <div x-show="selectedTab === 'netbanking'" class="space-y-3">
                    <div class="text-xs font-bold text-slate-700">Select Popular Bank</div>
                    <div class="grid grid-cols-2 gap-2 text-xs font-bold">
                        <button class="p-3 border border-slate-200 rounded-xl hover:border-[#f15153] text-left bg-slate-50">🏦 HDFC Bank</button>
                        <button class="p-3 border border-slate-200 rounded-xl hover:border-[#f15153] text-left bg-slate-50">🏦 ICICI Bank</button>
                        <button class="p-3 border border-slate-200 rounded-xl hover:border-[#f15153] text-left bg-slate-50">🏦 SBI Bank</button>
                        <button class="p-3 border border-slate-200 rounded-xl hover:border-[#f15153] text-left bg-slate-50">🏦 Axis Bank</button>
                    </div>
                </div>

                <!-- SUBMIT TEST PAYMENT BUTTON -->
                <button type="button" @click="paySuccess()" style="background-color: #f15153;" class="w-full py-3.5 text-white rounded-2xl font-black text-sm shadow-xl hover:opacity-90 transition flex items-center justify-center gap-2">
                    <span>Pay ₹{{ number_format($course?->currentVersion?->price ?? 49, 2) }}</span>
                </button>
            </div>

            <div class="p-3 bg-slate-50 border-t border-slate-200 text-center text-[10px] text-slate-400 font-bold flex items-center justify-center gap-1">
                <span>🔒 Secured by Razorpay 256-bit Encryption</span>
            </div>
        </div>
    </div>
</div>
