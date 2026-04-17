<x-layouts::app :title="__('Detail Mutasi Aset')">
    <flux:container class="max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <flux:heading level="1" size="xl">Detail Mutasi Aset</flux:heading>
                <flux:subheading>Informasi historis perpindahan lokasi aset</flux:subheading>
            </div>
            <flux:button :href="route('admin.mutations.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        {{-- Mutation Map Card --}}
        <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-8 mb-6 relative overflow-hidden">
            {{-- Visual Path --}}
            <div class="flex flex-col md:flex-row items-center justify-between relative z-10 gap-8 md:gap-4">
                {{-- From --}}
                <div class="flex flex-col items-center text-center space-y-4 flex-1">
                    <div class="size-16 rounded-2xl bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center border border-zinc-100 dark:border-zinc-800 shadow-sm">
                        <flux:icon.map-pin class="size-8 text-zinc-400" />
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">DARI LOKASI</p>
                        <flux:heading size="sm">{{ $mutation->fromLocation->name ?? 'N/A' }}</flux:heading>
                        <p class="text-xs text-zinc-500 font-mono">{{ $mutation->fromLocation->code ?? '-' }}</p>
                    </div>
                </div>

                {{-- The Arrow --}}
                <div class="flex flex-col items-center justify-center space-y-2">
                    <div class="hidden md:flex items-center">
                        <div class="h-0.5 w-12 bg-gradient-to-r from-zinc-200 via-indigo-200 to-indigo-500"></div>
                        <div class="size-8 rounded-full bg-indigo-50 dark:bg-indigo-900/40 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                            <flux:icon.arrow-right class="size-4 text-indigo-500" />
                        </div>
                        <div class="h-0.5 w-12 bg-indigo-500"></div>
                    </div>
                    {{-- Mobile Arrow --}}
                    <div class="md:hidden">
                        <flux:icon.arrow-down class="size-6 text-indigo-500 animate-bounce" />
                    </div>
                    <flux:badge color="indigo" size="sm" class="px-3">{{ $mutation->quantity }} {{ $mutation->asset->unit }}</flux:badge>
                </div>

                {{-- To --}}
                <div class="flex flex-col items-center text-center space-y-4 flex-1">
                    <div class="size-16 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800 shadow-sm">
                        <flux:icon.map-pin class="size-8 text-indigo-500" />
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-1">KE LOKASI (TUJUAN)</p>
                        <flux:heading size="sm" class="text-indigo-600 dark:text-indigo-400">{{ $mutation->toLocation->name ?? 'N/A' }}</flux:heading>
                        <p class="text-xs text-zinc-500 font-mono">{{ $mutation->toLocation->code ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Details --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center gap-2">
                        <div class="size-7 rounded-md bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center">
                            <flux:icon.document-text class="size-4 text-zinc-500" />
                        </div>
                        <flux:heading size="sm">Informasi Tambahan</flux:heading>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Aset Terkait</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $mutation->asset->name }}</p>
                                    <flux:badge size="sm" color="zinc" class="font-mono">{{ $mutation->asset->asset_code }}</flux:badge>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Dicatat Oleh</p>
                                <div class="flex items-center gap-2">
                                    <flux:avatar :name="$mutation->creator->name" size="xs" />
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $mutation->creator->name }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Waktu Mutasi</p>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $mutation->mutation_date?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>

                        <flux:separator variant="subtle" />

                        <div>
                            <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Keterangan / Alasan Mutasi</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg italic border border-zinc-100 dark:border-zinc-800">
                                "{{ $mutation->notes ?? 'Tidak ada keterangan tambahan.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-5">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-4">Aksi</p>
                    <div class="space-y-3">
                        <flux:button :href="route('admin.assets.show', $mutation->asset_id)" variant="primary" class="w-full" icon="eye">
                            Lihat Stok Aset
                        </flux:button>
                    </div>

                    <flux:separator class="my-5" variant="subtle" />
                    
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-lg">
                        <p class="text-[10px] text-indigo-700 dark:text-indigo-300 leading-normal font-medium">
                            Mutasi ini bersifat final. Jika terjadi kesalahan lokasi, silakan lakukan mutasi baru ke lokasi yang benar untuk memulihkan histori yang tepat.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </flux:container>
</x-layouts::app>
