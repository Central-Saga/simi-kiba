<x-layouts::app :title="__('Kelola Lokasi')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Kelola Lokasi</flux:heading>
                <flux:subheading>Daftar tempat/posisi fisik penyimpanan aset</flux:subheading>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.locations.index') }}" method="GET" class="w-full sm:w-64">
                    <flux:input icon="magnifying-glass" name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama..." clearable />
                </form>
                <flux:button :href="route('admin.locations.create')" icon="plus" variant="primary">Tambah Lokasi</flux:button>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <flux:icon.map-pin class="size-32" />
                </div>
                <flux:text class="text-indigo-100 font-medium uppercase tracking-wider text-xs">Total Lokasi</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $totalLocations }}</flux:heading>
                    <flux:text class="text-indigo-100 text-sm">Titik Penempatan</flux:text>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-amber-400 to-amber-500 text-white shadow-lg shadow-amber-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <flux:icon.archive-box class="size-32" />
                </div>
                <flux:text class="text-amber-50 font-medium uppercase tracking-wider text-xs">Lokasi Kosong</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $emptyLocations }}</flux:heading>
                    <flux:text class="text-amber-50 text-sm">Belum Terisi</flux:text>
                </div>
            </flux:card>

            <flux:card class="relative overflow-hidden group p-6 border-none bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-lg shadow-emerald-200 dark:shadow-none">
                <div class="absolute -right-4 -top-4 opacity-10 group-hover:scale-110 transition-transform duration-500">
                    <flux:icon.briefcase class="size-32" />
                </div>
                <flux:text class="text-emerald-50 font-medium uppercase tracking-wider text-xs">Aset Terpetakan</flux:text>
                <div class="flex items-baseline gap-2 mt-2">
                    <flux:heading level="3" size="xl" class="text-white">{{ $totalMappedAssets }}</flux:heading>
                    <flux:text class="text-emerald-50 text-sm">Item Terdata</flux:text>
                </div>
            </flux:card>
        </div>

        {{-- Table Section --}}
        <flux:card class="p-0 overflow-hidden shadow-sm border-zinc-200 dark:border-zinc-800">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Kode</flux:table.column>
                    <flux:table.column>Nama Lokasi</flux:table.column>
                    <flux:table.column>Status Isi</flux:table.column>
                    <flux:table.column align="right">Aksi</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($locations as $location)
                    <flux:table.row class="group hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                        <flux:table.cell>
                            <flux:badge size="sm" variant="subtle" color="indigo" class="font-mono font-bold px-3 py-1 rounded-lg">
                                {{ $location->code }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                    <flux:icon.map-pin class="size-4" />
                                </div>
                                <div>
                                    <div class="font-bold text-sm text-zinc-900 dark:text-white">{{ $location->name }}</div>
                                    <div class="text-xs text-zinc-500 truncate max-w-xs">{{ $location->description ?: '-' }}</div>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($location->assets_count > 0)
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-1">
                                        <div class="size-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 border-2 border-white dark:border-zinc-900 flex items-center justify-center">
                                            <flux:icon.check class="size-3 text-emerald-600 dark:text-emerald-400" />
                                        </div>
                                    </div>
                                    <flux:badge color="emerald" size="sm" variant="subtle" class="font-semibold">
                                        {{ $location->assets_count }} Aset
                                    </flux:badge>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="size-6 rounded-full bg-amber-100 dark:bg-amber-900/30 border-2 border-white dark:border-zinc-900 flex items-center justify-center">
                                        <flux:icon.minus class="size-3 text-amber-600 dark:text-amber-400" />
                                    </div>
                                    <flux:badge color="zinc" size="sm" variant="subtle" class="text-zinc-500">Kosong</flux:badge>
                                </div>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell align="right">
                            <div class="flex items-center gap-1 justify-end opacity-0 group-hover:opacity-100 transition-opacity">
                                <flux:button :href="route('admin.locations.edit', $location)" size="sm" icon="pencil-square" variant="ghost" class="hover:text-indigo-600" />
                                
                                <flux:modal.trigger name="delete-location-{{ $location->id }}">
                                    <flux:button size="sm" icon="trash" variant="ghost" color="danger" />
                                </flux:modal.trigger>

                                <flux:modal name="delete-location-{{ $location->id }}" class="md:w-[450px]">
                                    <div class="space-y-6">
                                        <div>
                                            <flux:heading size="lg">Hapus Lokasi?</flux:heading>
                                            <flux:subheading>Tindakan ini tidak dapat dibatalkan. Pastikan lokasi ini benar-benar ingin dihapus.</flux:subheading>
                                        </div>

                                        @if($location->assets_count > 0)
                                            <div class="p-4 bg-red-50 dark:bg-red-900/40 rounded-xl border border-red-100 dark:border-red-900/50 flex items-start gap-3">
                                                <flux:icon.exclamation-triangle class="size-5 text-red-600 shrink-0 mt-0.5" />
                                                <flux:text size="sm" class="text-red-700 dark:text-red-400">
                                                    Lokasi ini tidak bisa dihapus karena masih menampung <strong>{{ $location->assets_count }} aset</strong>. Silakan pindahkan aset terlebih dahulu.
                                                </flux:text>
                                            </div>
                                        @endif

                                        <div class="flex gap-2 pt-2">
                                            <flux:spacer />
                                            <flux:modal.close>
                                                <flux:button variant="ghost">Batal</flux:button>
                                            </flux:modal.close>
                                            
                                            <form action="{{ route('admin.locations.destroy', $location) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button type="submit" variant="primary" color="danger" :disabled="$location->assets_count > 0">Hapus Lokasi</flux:button>
                                            </form>
                                        </div>
                                    </div>
                                </flux:modal>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4">
                            <div class="flex flex-col items-center justify-center py-20 bg-zinc-50/50 dark:bg-zinc-800/20 rounded-xl">
                                <div class="p-6 bg-white dark:bg-zinc-800 rounded-3xl shadow-sm mb-6">
                                    <flux:icon.map-pin class="size-12 text-zinc-300 dark:text-zinc-600" />
                                </div>
                                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Belum Ada Lokasi</flux:heading>
                                <flux:subheading class="max-w-xs text-center mt-2">Daftar lokasi fisik akan muncul di sini setelah Anda menambahkannya.</flux:subheading>
                                <flux:button :href="route('admin.locations.create')" variant="primary" icon="plus" class="mt-8">Tambah Lokasi Pertama</flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>

        @if($locations->hasPages())
        <div class="mt-4">
            {{ $locations->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
