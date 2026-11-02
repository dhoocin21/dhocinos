<div class="fixed {{ $isOpen ? 'bottom-6 right-4 sm:bottom-8 sm:right-8 z-50' : 'bottom-24 right-4 sm:bottom-28 sm:right-8 z-40' }}">
    <!-- Floating Trigger Button -->
    @if(!$isOpen)
        <button 
            type="button" 
            wire:click="toggleChat"
            class="group relative flex items-center gap-3 bg-gradient-to-r from-[#002c5f] to-blue-700 hover:from-blue-900 hover:to-blue-600 text-white px-5 py-3.5 rounded-full shadow-2xl transition-all duration-300 hover:scale-105 border-2 border-white/20"
        >
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-400"></span>
            </span>
            <div class="w-6 h-6 flex items-center justify-center text-cyan-300">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
            </div>
            <div class="text-left hidden sm:block">
                <div class="text-xs font-black tracking-wider uppercase">Tanya AI Showroom</div>
                <div class="text-[10px] text-blue-200">Konsultasi Unit & Promo</div>
            </div>
        </button>
    @endif

    <!-- Chat Modal Window -->
    @if($isOpen)
        <div class="w-[92vw] sm:w-[410px] h-[580px] bg-white rounded-3xl shadow-2xl border border-gray-200 flex flex-col overflow-hidden animate-in fade-in slide-in-from-bottom-6 duration-300 relative">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#002c5f] to-blue-900 text-white p-4 flex items-center justify-between shadow-md shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-cyan-300 font-bold">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-wider text-white flex items-center gap-1.5">
                            AI Sales Consultant
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        </h4>
                        <p class="text-[10px] text-blue-200">Hyundai Gowa Surabaya • Online 24 Jam</p>
                    </div>
                </div>

                <div class="flex items-center gap-1.5">
                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', optional($consultant)->phone ?? '081330135013');
                        if (str_starts_with($cleanPhone, '0')) $cleanPhone = '62' . substr($cleanPhone, 1);
                    @endphp
                    <a 
                        href="https://wa.me/{{ $cleanPhone }}?text=Halo%20Mas%20Nico%2C%20saya%20ingin%20konsultasi%20langsung%20promo%20unit%20Hyundai" 
                        target="_blank" 
                        class="p-2 text-emerald-400 hover:text-emerald-300 bg-white/10 hover:bg-white/20 rounded-xl transition"
                        title="Chat WhatsApp Sales Langsung"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    </a>
                    <button 
                        type="button" 
                        wire:click="toggleChat"
                        class="p-2 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 rounded-xl transition"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="flex-1 p-4 overflow-y-auto space-y-3 bg-gray-50/50 text-xs">
                @foreach($messages as $msg)
                    <div class="flex flex-col {{ $msg['role'] === 'user' ? 'items-end' : 'items-start' }}">
                        <div class="max-w-[88%] p-3.5 rounded-2xl shadow-sm leading-relaxed {{ $msg['role'] === 'user' ? 'bg-[#002c5f] text-white rounded-br-sm' : 'bg-white text-gray-800 border border-gray-200/80 rounded-bl-sm' }}">
                            {!! nl2br(e($msg['text'])) !!}
                        </div>
                        <span class="text-[9px] text-gray-400 mt-1 px-1">{{ $msg['time'] ?? '' }}</span>
                    </div>
                @endforeach

                <!-- Mandatory Lead Form Inside Chat (Displayed if not yet captured) -->
                @if(!$isLeadCaptured)
                    <div class="bg-gradient-to-br from-blue-50/90 to-indigo-50/90 border-2 border-blue-200/80 rounded-2xl p-4 shadow-md space-y-3 mt-2 animate-in fade-in duration-300">
                        <div class="flex items-center justify-between pb-2 border-b border-blue-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                <h5 class="text-[11px] font-black uppercase tracking-wider text-[#002c5f]">Formulir Konsultasi Resmi</h5>
                            </div>
                            <span class="text-[9px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full border border-amber-200">Wajib Diisi</span>
                        </div>
                        
                        <p class="text-[11px] text-gray-600 leading-snug">
                            Masukkan data singkat Anda sebelum AI memberikan rekomendasi harga OTR dan promo diskon:
                        </p>

                        <form wire:submit.prevent="submitLead" class="space-y-2.5">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Nomor Telepon / WhatsApp <span class="text-red-500 font-black">*Wajib</span>
                                </label>
                                <input 
                                    type="tel" 
                                    wire:model="leadPhone" 
                                    placeholder="Contoh: 081234567890" 
                                    class="w-full text-xs px-3 py-2 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none font-semibold text-gray-900"
                                    required
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Nama Lengkap <span class="text-red-500 font-black">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="leadName" 
                                        placeholder="Nama Anda" 
                                        class="w-full text-xs px-3 py-2 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none text-gray-900"
                                        required
                                    >
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Domisili / Kota <span class="text-red-500 font-black">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        wire:model="leadCity" 
                                        placeholder="Contoh: Surabaya" 
                                        class="w-full text-xs px-3 py-2 rounded-xl border border-gray-300 bg-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none text-gray-900"
                                        required
                                    >
                                </div>
                            </div>

                            <button 
                                type="submit" 
                                wire:loading.attr="disabled"
                                class="w-full py-2.5 bg-[#002c5f] hover:bg-blue-800 text-white font-bold rounded-xl text-xs uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2"
                            >
                                <span wire:loading.remove>Kirim & Mulai Tanya AI</span>
                                <span wire:loading class="flex items-center gap-1.5">
                                    <svg class="animate-spin h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses Data...
                                </span>
                            </button>
                        </form>
                    </div>
                @endif

                @if($isTyping)
                    <div class="flex items-center gap-1.5 p-3 bg-white rounded-2xl w-fit shadow-sm border border-gray-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.2s]"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-bounce [animation-delay:0.4s]"></span>
                    </div>
                @endif
            </div>

            <!-- Quick Questions Pills (Visible when lead captured) -->
            @if($isLeadCaptured)
                <div class="px-3 py-2 bg-white border-t border-gray-100 overflow-x-auto flex gap-1.5 no-scrollbar shrink-0">
                    <button type="button" wire:click="sendQuickPrompt('Rekomendasikan mobil budget 300 jutaan')" class="whitespace-nowrap text-[10px] bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full hover:bg-blue-100 font-semibold transition">
                        💡 Budget 300 Jutaan
                    </button>
                    <button type="button" wire:click="sendQuickPrompt('Beda Stargazer dan Creta apa?')" class="whitespace-nowrap text-[10px] bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full hover:bg-blue-100 font-semibold transition">
                        ⚖️ Stargazer vs Creta
                    </button>
                    <button type="button" wire:click="sendQuickPrompt('Info promo kredit Ioniq 5')" class="whitespace-nowrap text-[10px] bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full hover:bg-blue-100 font-semibold transition">
                        ⚡ Promo Ioniq 5
                    </button>
                </div>
            @endif

            <!-- Input Bar -->
            <div class="p-3 bg-white border-t border-gray-100 shrink-0">
                <form wire:submit.prevent="sendMessage" class="flex items-center gap-2">
                    <input 
                        type="text" 
                        wire:model="userMessage" 
                        placeholder="{{ $isLeadCaptured ? 'Tanya info mobil, DP, atau promo...' : 'Ketik pertanyaan / no. WhatsApp Anda...' }}" 
                        class="flex-1 text-xs px-3.5 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-[#002c5f] focus:outline-none transition"
                    >
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="p-2.5 bg-[#002c5f] hover:bg-blue-800 text-white rounded-xl shadow-md transition disabled:opacity-50"
                        title="Kirim Pesan"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    </button>
                </form>
            </div>

            <!-- POP UP WHATSAPP SALES MODAL (Triggered when phone number is missing / requested) -->
            @if($showWhatsappPopup)
                <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-in fade-in zoom-in-95 duration-200">
                    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 w-full max-w-[340px] overflow-hidden text-center flex flex-col">
                        <!-- Top Banner -->
                        <div class="bg-gradient-to-br from-[#002c5f] to-blue-900 text-white p-5 relative">
                            <button 
                                type="button" 
                                wire:click="closeWhatsappPopup"
                                class="absolute top-3 right-3 text-white/70 hover:text-white p-1 rounded-full bg-white/10 hover:bg-white/20 transition"
                            >
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </button>

                            <div class="relative w-16 h-16 mx-auto mb-3">
                                @if(optional($consultant)->photo)
                                    <img src="{{ asset('storage/' . $consultant->photo) }}" alt="Sales Consultant" class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-blue-700 border-2 border-white flex items-center justify-center text-xl font-bold">
                                        N
                                    </div>
                                @endif
                                <span class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                            </div>

                            <h4 class="text-sm font-black uppercase tracking-wider text-white">
                                {{ optional($consultant)->name ?? 'Nico - Sales Executive' }}
                            </h4>
                            <p class="text-[10px] text-blue-200 mt-0.5">Dealer Resmi Hyundai Gowa HR Muhammad</p>
                            
                            <div class="mt-2 inline-flex items-center gap-1 bg-white/10 border border-white/20 px-2.5 py-0.5 rounded-full text-[10px] font-semibold text-cyan-200">
                                <svg class="w-3 h-3 text-cyan-300" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                <span>Sales Konsultan Resmi Terverifikasi</span>
                            </div>
                        </div>

                        <!-- Body Content -->
                        <div class="p-5 space-y-3.5">
                            <div class="text-left bg-amber-50 border border-amber-200 rounded-xl p-2.5">
                                <p class="text-[11px] text-amber-900 font-medium leading-snug">
                                    {{ $popupReason ?: 'Sebelum AI dapat menjawab, Anda wajib melengkapi nomor telepon atau bisa langsung terhubung dengan Sales Executive kami.' }}
                                </p>
                            </div>

                            <p class="text-xs text-gray-600 leading-relaxed">
                                Dapatkan promo diskon OTR Surabaya terbesar, simulasi hitungan kredit DP minim, dan penawaran spesial langsung via WhatsApp:
                            </p>

                            <div class="space-y-2 pt-1">
                                <a 
                                    href="https://wa.me/{{ $cleanPhone }}?text=Halo%20Mas%20Nico%2C%20saya%20tertarik%20konsultasi%20promo%20unit%20Hyundai%20Surabaya."
                                    target="_blank"
                                    class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs uppercase tracking-wider rounded-2xl shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.83a8.17 8.17 0 0 1-5.82 2.41h-.01c-1.48 0-2.93-.39-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.17 8.17 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.25-8.24m4.52 11.64c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.78.6.26 1.07.41 1.43.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.06-.11-.23-.17-.48-.29z"/></svg>
                                    <span>Chat WhatsApp Sales Nico</span>
                                </a>

                                <button 
                                    type="button" 
                                    wire:click="closeWhatsappPopup"
                                    class="w-full py-2.5 px-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition"
                                >
                                    Isi Nomor Telepon di Chat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endif
</div>
