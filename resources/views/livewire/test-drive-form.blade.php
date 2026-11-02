<div class="bg-white dark:bg-[#0c1527] rounded-[2.5rem] p-8 md:p-10 shadow-2xl shadow-gray-200/50 dark:shadow-black/50 border border-gray-100 dark:border-slate-800/80 h-full flex flex-col justify-between transition-colors">
    <div class="space-y-6">
        @if($successMessage)
            <div class="bg-green-50 dark:bg-green-950/60 border border-green-300 dark:border-green-800 text-green-800 dark:text-green-300 px-6 py-4 rounded-2xl text-xs font-bold flex items-center gap-3 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ $successMessage }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Nama Lengkap</label>
                <input type="text" wire:model="name" placeholder="Sesuai KTP" 
                       class="w-full bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 border border-gray-300 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Nomor WhatsApp</label>
                <input type="tel" wire:model="phone" placeholder="0812xxxx" 
                       class="w-full bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 border border-gray-300 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Pilih Unit Mobil</label>
                <select wire:model="car_id" class="w-full bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white border border-gray-300 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
                    <option value="" class="text-gray-600 dark:text-gray-400">-- Pilih Unit --</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" class="text-gray-900 dark:text-white bg-white dark:bg-slate-900">{{ $car->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Rencana Tanggal</label>
                <input type="date" wire:model="booking_date" 
                       class="w-full bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white border border-gray-300 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all shadow-sm">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-widest px-1">Catatan Tambahan (Opsional)</label>
            <textarea wire:model="notes" placeholder="Tulis permintaan khusus Anda di sini..." 
                      class="w-full bg-slate-50 dark:bg-slate-800 text-gray-950 dark:text-white placeholder:text-gray-500 dark:placeholder:text-gray-400 border border-gray-300 dark:border-slate-700 rounded-2xl p-4 text-sm font-bold focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all h-24 shadow-sm"></textarea>
        </div>
    </div>

    <button wire:click="submit" 
            wire:loading.attr="disabled"
            class="mt-8 w-full bg-[#002c5f] hover:bg-blue-900 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-[0.2em] transition-all shadow-xl shadow-blue-900/20 flex items-center justify-center gap-3 group disabled:opacity-70 disabled:cursor-not-allowed cursor-pointer">
        <span wire:loading.remove>Konfirmasi Booking</span>
        <span wire:loading>Memproses...</span>
        <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        <svg wire:loading class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg>
    </button>
</div>
