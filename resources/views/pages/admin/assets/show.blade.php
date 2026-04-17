<x-layouts::app :title="__('Detail Aset: ' . $asset->name)">
    <flux:container class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <flux:heading level="1" size="xl">Detail Aset</flux:heading>
                <flux:subheading>Informasi lengkap inventaris untuk {{ $asset->asset_code }}</flux:subheading>
            </div>
            <div class="flex items-center gap-2">
                <flux:button :href="route('admin.assets.edit', $asset)" variant="primary" icon="pencil-square">Edit Aset</flux:button>
                <flux:button :href="route('admin.assets.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
            </div>
        </div>

        {{-- 2-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Primary Info --}}
            <div class="lg:col-span-2 space-y-6">
                <flux:card class="p-0 overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                <flux:icon.archive-box variant="outline" />
                            </div>
                            <flux:heading size="lg">Informasi Utama</flux:heading>
                        </div>
                        @php
                            $color = match($asset->condition) {
                                'baik' => 'emerald',
                                'cukup' => 'amber',
                                'rusak' => 'red',
                                default => 'zinc'
                            };
                        @endphp
                        <flux:badge :color="$color" size="md" variant="subtle">{{ ucfirst($asset->condition) }}</flux:badge>
                    </div>

                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Nama Aset</flux:text>
                                <flux:text size="lg" class="font-medium mt-1">{{ $asset->name }}</flux:text>
                            </div>
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Kode Inventaris</flux:text>
                                <flux:text size="md" class="font-mono mt-1 text-indigo-600 dark:text-indigo-400">{{ $asset->asset_code }}</flux:text>
                            </div>
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Kategori</flux:text>
                                <flux:text size="md" class="mt-1">{{ $asset->category }}</flux:text>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Lokasi Saat Ini</flux:text>
                                <div class="flex items-center gap-2 mt-1">
                                    <flux:icon.map-pin class="size-4 text-zinc-400" />
                                    <flux:text size="md" class="font-medium">{{ $asset->location->name ?? '-' }}</flux:text>
                                    <flux:badge size="sm" variant="outline" class="font-mono">{{ $asset->location->code ?? '-' }}</flux:badge>
                                </div>
                            </div>
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Stok / Jumlah</flux:text>
                                <div class="flex items-baseline gap-1 mt-1">
                                    <flux:text size="xl" class="font-bold {{ $asset->quantity <= 0 ? 'text-red-500' : '' }}">{{ $asset->quantity }}</flux:text>
                                    <flux:text size="sm" color="zinc">{{ $asset->unit }}</flux:text>
                                </div>
                            </div>
                            <div>
                                <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold">Tanggal Input</flux:text>
                                <flux:text size="md" class="mt-1">{{ $asset->created_at->format('d F Y') }}</flux:text>
                            </div>
                        </div>

                        @if($asset->description)
                        <div class="sm:col-span-2 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <flux:text size="xs" variant="secondary" class="uppercase tracking-widest font-semibold mb-2 block">Deskripsi / Catatan</flux:text>
                            <flux:text size="sm" class="leading-relaxed">{{ $asset->description }}</flux:text>
                        </div>
                        @endif
                    </div>
                </flux:card>

                {{-- Usage History --}}
                <flux:card class="p-0 overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <flux:icon.clock variant="outline" />
                            </div>
                            <flux:heading size="lg">Riwayat Penggunaan</flux:heading>
                        </div>
                        <flux:badge color="zinc" size="sm" variant="subtle">{{ $asset->usages->count() }} Entri</flux:badge>
                    </div>

                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column>Tanggal</flux:table.column>
                            <flux:table.column>Pengguna</flux:table.column>
                            <flux:table.column>Jumlah</flux:table.column>
                            <flux:table.column>Keterangan</flux:table.column>
                        </flux:table.columns>
                        <flux:table.rows>
                            @forelse($asset->usages->sortByDesc('used_at')->take(10) as $usage)
                                <flux:table.row>
                                    <flux:table.cell class="whitespace-nowrap">{{ $usage->used_at?->format('d M Y') ?? $usage->created_at->format('d M Y') }}</flux:table.cell>
                                    <flux:table.cell>
                                        <flux:text size="sm" class="font-medium">{{ $usage->user->name ?? '-' }}</flux:text>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:text size="sm" class="font-medium">{{ $usage->quantity }} {{ $asset->unit }}</flux:text>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <flux:text size="xs" color="zinc" class="max-w-xs truncate">{{ $usage->notes ?? '-' }}</flux:text>
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="4" class="text-center py-8 text-zinc-400">Belum ada riwayat penggunaan</flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.rows>
                    </flux:table>
                </flux:card>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Quick Actions --}}
                <flux:card>
                    <flux:heading size="lg" class="mb-4">Tindakan</flux:heading>
                    <div class="grid grid-cols-1 gap-2">
                        <flux:button :href="route('admin.assets.edit', $asset)" icon="pencil-square" class="justify-start">Edit Data Aset</flux:button>
                        <flux:modal.trigger name="delete-asset">
                            <flux:button variant="ghost" color="danger" icon="trash" class="w-full justify-start">Hapus Aset</flux:button>
                        </flux:modal.trigger>
                    </div>
                </flux:card>

                {{-- Mutation History --}}
                <flux:card class="p-0 overflow-hidden">
                    <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                        <flux:heading size="md">Log Mutasi</flux:heading>
                        <flux:badge color="zinc" size="sm" variant="subtle">{{ $asset->mutations->count() }}</flux:badge>
                    </div>
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($asset->mutations->sortByDesc('mutation_date')->take(5) as $mutation)
                            <div class="p-4 space-y-2">
                                <div class="flex items-center gap-2 text-xs">
                                    <flux:text color="zinc">{{ $mutation->mutation_date?->format('d M Y') ?? '-' }}</flux:text>
                                    <flux:badge size="xs" variant="outline">{{ $mutation->quantity }} {{ $asset->unit }}</flux:badge>
                                </div>
                                <div class="flex items-center gap-2 py-1">
                                    <div class="flex-1 min-w-0">
                                        <flux:text size="sm" class="truncate block">{{ $mutation->fromLocation->name ?? 'External' }}</flux:text>
                                    </div>
                                    <flux:icon.arrow-right class="size-3 text-zinc-300" />
                                    <div class="flex-1 min-w-0">
                                        <flux:text size="sm" class="truncate font-medium block text-indigo-600 dark:text-indigo-400">{{ $mutation->toLocation->name ?? '-' }}</flux:text>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-sm text-zinc-400">Tidak ada riwayat mutasi</div>
                        @endforelse
                    </div>
                </flux:card>
            </div>
        </div>

        {{-- Delete Modal --}}
        <flux:modal name="delete-asset" class="md:w-[450px]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Hapus Aset?</flux:heading>
                    <flux:subheading>Tindakan ini akan menghapus data aset <strong>{{ $asset->name }}</strong> secara permanen.</flux:subheading>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Batal</flux:button>
                    </flux:modal.close>
                    
                    <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" variant="primary" color="danger">Hapus Sekarang</flux:button>
                    </form>
                </div>
            </div>
        </flux:modal>

    </flux:container>
</x-layouts::app>
