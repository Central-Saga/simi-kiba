<x-layouts::app :title="__('Riwayat Penggunaan Aset')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Riwayat Penggunaan Aset</flux:heading>
                <flux:subheading>Catatan pengambilan dan penggunaan aset inventaris</flux:subheading>
            </div>
            
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.usages.index') }}" method="GET" class="w-full sm:w-64">
                    <flux:input icon="magnifying-glass" name="search" value="{{ request('search') }}" placeholder="Cari nama aset..." clearable />
                </form>
                <flux:button :href="route('admin.usages.create')" icon="plus" variant="primary">Catat Penggunaan</flux:button>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Aset</flux:table.column>
                <flux:table.column>Pengguna</flux:table.column>
                <flux:table.column>Tanggal</flux:table.column>
                <flux:table.column>Jumlah</flux:table.column>
                <flux:table.column>Tujuan</flux:table.column>
                <flux:table.column align="right">Aksi</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($usages as $usage)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-900 dark:text-white">{{ $usage->asset->name }}</div>
                        <div class="text-xs text-indigo-600 dark:text-indigo-400 font-bold uppercase">{{ $usage->asset->asset_code }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-700 dark:text-zinc-300">{{ $usage->user->name }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-700 dark:text-zinc-300 font-medium">{{ $usage->usage_date->format('d M Y') }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="font-bold text-sm text-zinc-900 dark:text-white">{{ $usage->quantity }} <span class="text-xs text-zinc-500 font-normal">{{ $usage->asset->unit }}</span></div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-500 max-w-xs truncate">{{ $usage->purpose }}</div>
                    </flux:table.cell>
                    <flux:table.cell align="right">
                        <flux:button :href="route('admin.usages.show', $usage)" size="sm" icon="eye" variant="ghost" inset="top bottom" />
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5">
                        <div class="flex flex-col items-center justify-center py-10">
                            <flux:icon.clock class="size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                            <flux:subheading>Belum ada riwayat penggunaan aset.</flux:subheading>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($usages->hasPages())
        <div class="mt-4">
            {{ $usages->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
