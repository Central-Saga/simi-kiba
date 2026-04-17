<x-layouts::app :title="__('Riwayat Mutasi Aset')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Riwayat Mutasi Aset</flux:heading>
                <flux:subheading>Catatan perpindahan lokasi penyimpanan aset</flux:subheading>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.mutations.index') }}" method="GET" class="w-full sm:w-64">
                    <flux:input icon="magnifying-glass" name="search" value="{{ request('search') }}" placeholder="Cari nama aset..." clearable />
                </form>
                <flux:button :href="route('admin.mutations.create')" icon="arrows-right-left" variant="primary">Pindah Lokasi Aset</flux:button>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Aset</flux:table.column>
                <flux:table.column>Perpindahan Lokasi</flux:table.column>
                <flux:table.column>Tanggal & Jumlah</flux:table.column>
                <flux:table.column>Oleh</flux:table.column>
                <flux:table.column align="right">Aksi</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($mutations as $mutation)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-900 dark:text-white">{{ $mutation->asset->name }}</div>
                        <div class="text-xs text-indigo-600 dark:text-indigo-400 font-bold uppercase">{{ $mutation->asset->asset_code }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex items-center space-x-2 text-sm">
                            <span class="font-medium text-zinc-600 dark:text-zinc-400">{{ $mutation->fromLocation->name }}</span>
                            <flux:icon.arrow-right class="size-4 text-zinc-400" />
                            <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $mutation->toLocation->name }}</span>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-900 dark:text-white">{{ $mutation->mutation_date->format('d M Y') }}</div>
                        <div class="text-xs text-zinc-500 font-bold">{{ $mutation->quantity }} <span class="font-normal">{{ $mutation->asset->unit }}</span></div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-500">{{ $mutation->creator->name }}</div>
                    </flux:table.cell>
                    <flux:table.cell align="right">
                         <flux:button :href="route('admin.mutations.show', $mutation)" size="sm" icon="eye" variant="ghost" inset="top bottom" />
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="4">
                        <div class="flex flex-col items-center justify-center py-10">
                            <flux:icon.arrows-right-left class="size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                            <flux:subheading>Belum ada riwayat mutasi aset.</flux:subheading>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($mutations->hasPages())
        <div class="mt-4">
            {{ $mutations->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
