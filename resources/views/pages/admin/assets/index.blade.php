<x-layouts::app :title="__('Kelola Aset Inventaris')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Kelola Aset Inventaris</flux:heading>
                <flux:subheading>Daftar seluruh aset, filter kategori, dan pantau stok</flux:subheading>
            </div>
            
            <flux:button :href="route('admin.assets.create')" icon="plus" variant="primary">Tambah Aset Baru</flux:button>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg shadow-blue-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <flux:icon.archive-box class="size-32" />
                </div>
                <flux:text class="text-blue-100 font-medium uppercase tracking-wider text-xs">Total Aset</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $totalAssets }}</flux:heading>
                    <flux:text class="text-blue-100 text-sm">Inventaris</flux:text>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-emerald-400 to-teal-500 text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <flux:icon.check-circle class="size-32" />
                </div>
                <flux:text class="text-emerald-50 font-medium uppercase tracking-wider text-xs">Kondisi Baik</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $baikCount }}</flux:heading>
                    <flux:text class="text-emerald-50 text-sm">Siap Pakai</flux:text>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-lg shadow-amber-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <flux:icon.exclamation-triangle class="size-32" />
                </div>
                <flux:text class="text-amber-50 font-medium uppercase tracking-wider text-xs">Kondisi Cukup</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $cukupCount }}</flux:heading>
                    <flux:text class="text-amber-50 text-sm">Perlu Pantau</flux:text>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-rose-500 to-red-600 text-white shadow-lg shadow-rose-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                    <flux:icon.x-circle class="size-32" />
                </div>
                <flux:text class="text-rose-100 font-medium uppercase tracking-wider text-xs">Kondisi Rusak</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $rusakCount }}</flux:heading>
                    <flux:text class="text-rose-100 text-sm">Butuh Tindakan</flux:text>
                </div>
            </flux:card>
        </div>

        {{-- Filter Section --}}
        <flux:card class="p-6 rounded-2xl shadow-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-visible">
            <form action="{{ route('admin.assets.index') }}" method="GET" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-end">
                <div class="lg:col-span-4">
                    <flux:input icon="magnifying-glass" name="search" label="Cari Aset" value="{{ request('search') }}" placeholder="Kode atau nama aset..." />
                </div>
                
                <div class="lg:col-span-3">
                    <flux:select name="category" label="Kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </flux:select>
                </div>
                
                <div class="lg:col-span-3">
                    <flux:select name="condition" label="Kondisi Fisik">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" {{ request('condition') === 'baik' ? 'selected' : '' }}>Baik (Normal)</option>
                        <option value="cukup" {{ request('condition') === 'cukup' ? 'selected' : '' }}>Cukup (Biasa)</option>
                        <option value="rusak" {{ request('condition') === 'rusak' ? 'selected' : '' }}>Rusak (Bermasalah)</option>
                    </flux:select>
                </div>
                
                <div class="lg:col-span-2 flex items-center gap-2 pb-0.5">
                    <flux:button type="submit" variant="primary" class="flex-1 shadow-md shadow-indigo-200 dark:shadow-none">Filter</flux:button>
                    @if(request()->hasAny(['search', 'category', 'condition']))
                        <flux:button :href="route('admin.assets.index')" variant="ghost" icon="x-mark" />
                    @endif
                </div>
            </form>
        </flux:card>

        {{-- Table Section --}}
        <flux:card class="p-0 rounded-2xl shadow-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 overflow-hidden">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Kode</flux:table.column>
                    <flux:table.column class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Informasi Aset</flux:table.column>
                    <flux:table.column class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Detail Lokasi</flux:table.column>
                    <flux:table.column class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Stok Efektif</flux:table.column>
                    <flux:table.column class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Kondisi</flux:table.column>
                    <flux:table.column align="right" class="bg-zinc-50/50 dark:bg-white/5 font-semibold py-4">Aksi</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($assets as $asset)
                    <flux:table.row class="group transition-all duration-200 {{ $asset->quantity <= 0 || $asset->condition === 'rusak' ? 'bg-red-50/30 dark:bg-red-900/10' : 'hover:bg-zinc-50 dark:hover:bg-white/5' }}">
                        <flux:table.cell>
                            <flux:badge size="sm" variant="subtle" color="blue" class="font-mono font-bold px-3 py-1 rounded-lg">
                                {{ $asset->asset_code }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-xl bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-700 flex items-center justify-center text-zinc-500 shadow-inner">
                                    <flux:icon.archive-box class="size-5" />
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-zinc-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $asset->name }}</div>
                                    <div class="text-xs text-zinc-500 overflow-hidden text-ellipsis line-clamp-1 max-w-[200px]">{{ $asset->description ?: 'Bentuk aset belum dideskripsikan' }}</div>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-col gap-1">
                                <flux:badge size="sm" variant="subtle" color="violet" class="w-fit">{{ $asset->category }}</flux:badge>
                                <div class="flex items-center gap-1.5 text-xs text-zinc-500">
                                    <flux:icon.map-pin class="size-3 text-red-400" />
                                    <span class="font-medium">{{ $asset->location->name ?? '-' }}</span>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($asset->quantity <= 0)
                                <flux:badge color="red" size="sm" variant="solid" class="animate-pulse">Habis</flux:badge>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="font-bold text-sm text-zinc-900 dark:text-white">{{ $asset->quantity }}</div>
                                    <div class="text-[10px] font-bold uppercase text-zinc-400 px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800">{{ $asset->unit }}</div>
                                </div>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            @php
                                $statusConf = match($asset->condition) {
                                    'baik' => ['color' => 'emerald', 'icon' => 'check-circle'],
                                    'cukup' => ['color' => 'amber', 'icon' => 'exclamation-triangle'],
                                    'rusak' => ['color' => 'red', 'icon' => 'x-circle'],
                                    default => ['color' => 'zinc', 'icon' => 'question-mark-circle']
                                };
                            @endphp
                            <flux:badge :color="$statusConf['color']" size="sm" variant="subtle" class="font-bold border-none capitalize">
                                <flux:icon :icon="$statusConf['icon']" class="size-3 mr-1.5" />
                                {{ $asset->condition }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell align="right">
                            <div class="flex items-center gap-1 justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                <flux:button :href="route('admin.assets.show', $asset)" size="sm" icon="eye" variant="ghost" class="hover:text-blue-500" />
                                <flux:button :href="route('admin.assets.edit', $asset)" size="sm" icon="pencil-square" variant="ghost" class="hover:text-indigo-500" />
                                
                                <flux:modal.trigger name="delete-asset-{{ $asset->id }}">
                                    <flux:button size="sm" icon="trash" variant="ghost" color="danger" />
                                </flux:modal.trigger>

                                <flux:modal name="delete-asset-{{ $asset->id }}" class="md:w-[450px]">
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
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6">
                            <div class="flex flex-col items-center justify-center py-20 bg-zinc-50/50 dark:bg-zinc-800/10 rounded-2xl">
                                <div class="p-6 bg-white dark:bg-zinc-800 rounded-3xl shadow-sm mb-6">
                                    <flux:icon.archive-box class="size-12 text-zinc-300 dark:text-zinc-600" />
                                </div>
                                <flux:heading size="lg">Aset Tidak Ditemukan</flux:heading>
                                <flux:subheading class="mt-2">Pencarian untuk kriteria tersebut tidak membuahkan hasil.</flux:subheading>
                                <flux:button :href="route('admin.assets.index')" variant="subtle" class="mt-8">Reset Semua Filter</flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>

        @if($assets->hasPages())
        <div class="mt-4">
            {{ $assets->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
