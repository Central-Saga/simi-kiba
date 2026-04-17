<x-layouts::app :title="__('Detail Penggunaan Aset')">
    <flux:container class="max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <flux:heading level="1" size="xl">Detail Penggunaan Aset</flux:heading>
                <flux:subheading>Informasi historis pemakaian aset oleh pengguna</flux:subheading>
            </div>
            <flux:button :href="route('admin.usages.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        {{-- Detail Card --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            {{-- Left Side: Main Info --}}
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center gap-2">
                        <div class="size-7 rounded-md bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                            <flux:icon.clock class="size-4 text-indigo-500" />
                        </div>
                        <flux:heading size="sm">Informasi Transaksi</flux:heading>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Aset</p>
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                                        <flux:icon.archive-box class="size-5 text-zinc-400" />
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">{{ $usage->asset->name }}</p>
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-mono">{{ $usage->asset->asset_code }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Jumlah Pemakaian</p>
                                <p class="text-lg font-bold text-zinc-900 dark:text-white">
                                    {{ $usage->quantity }} <span class="text-sm font-normal text-zinc-500">{{ $usage->asset->unit }}</span>
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Pengguna</p>
                                <div class="flex items-center gap-2">
                                    <flux:avatar :name="$usage->user->name" size="xs" />
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $usage->user->name }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Tanggal Transaksi</p>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $usage->usage_date?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>

                        <flux:separator variant="subtle" />

                        <div>
                            <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Tujuan Penggunaan</p>
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-100 dark:border-zinc-800">
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed italic">
                                    "{{ $usage->purpose }}"
                                </p>
                            </div>
                        </div>

                        @if($usage->notes)
                        <div>
                            <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Catatan Tambahan</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                                {{ $usage->notes }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Side: Quick Specs / Actions --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-5">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-4">Ringkasan Status</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-zinc-500">Kategori Aset</span>
                            <flux:badge size="sm" color="zinc">{{ $usage->asset->category }}</flux:badge>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-zinc-500">Lokasi Asal</span>
                            <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">{{ $usage->asset->location->name }}</span>
                        </div>
                    </div>

                    <flux:separator class="my-5" variant="subtle" />

                    <div class="space-y-3">
                        <flux:button :href="route('admin.assets.show', $usage->asset_id)" variant="primary" class="w-full" icon="eye">
                            Lihat Stok Aset
                        </flux:button>
                        
                        {{-- Logika Bisnis: Admin tidak mengedit penggunaan, tapi bisa melakukan verifikasi pengembalian jika perlu --}}
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-lg">
                            <div class="flex gap-2">
                                <flux:icon.information-circle class="size-4 text-amber-500 shrink-0" />
                                <p class="text-[10px] text-amber-700 dark:text-amber-300 leading-normal font-medium">
                                    Data transaksi ini bersifat historis. Perubahan data aset (stok) telah dikalkulasi saat transaksi disimpan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </flux:container>
</x-layouts::app>
