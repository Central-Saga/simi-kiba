<x-layouts::app :title="__('Laporan Inventaris Aset')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Laporan Inventaris Aset</flux:heading>
                <flux:subheading>Filter dan cetak laporan aset secara spesifik</flux:subheading>
            </div>
        </div>

        <flux:card>
            <div class="flex items-center gap-2 mb-6">
                <flux:icon.funnel class="size-5 text-zinc-400" />
                <flux:heading size="lg">Filter Laporan</flux:heading>
            </div>
            
            <form action="{{ route('admin.reports.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <flux:select name="location_id" label="Lokasi Penempatan">
                        <option value="">Semua Lokasi</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select name="category" label="Kategori Aset">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </flux:select>

                    <flux:select name="condition" label="Kondisi Fisik">
                        <option value="">Semua Kondisi</option>
                        <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="cukup" {{ request('condition') == 'cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="rusak" {{ request('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    </flux:select>
                </div>
                
                <div class="flex flex-col sm:flex-row justify-between items-center mt-8 pt-6 border-t border-zinc-100 dark:border-zinc-800 gap-4">
                    <div class="flex flex-wrap gap-2">
                        @if(request('location_id'))
                            <flux:badge color="zinc" variant="outline" size="sm" class="pl-1.5"><span class="text-zinc-400 mr-1.5">Lokasi:</span>{{ $locations->find(request('location_id'))->name }}</flux:badge>
                        @endif
                        @if(request('category'))
                            <flux:badge color="zinc" variant="outline" size="sm" class="pl-1.5"><span class="text-zinc-400 mr-1.5">Kategori:</span>{{ request('category') }}</flux:badge>
                        @endif
                        @if(request('condition'))
                            <flux:badge color="zinc" variant="outline" size="sm" class="pl-1.5"><span class="text-zinc-400 mr-1.5">Kondisi:</span>{{ ucfirst(request('condition')) }}</flux:badge>
                        @endif
                    </div>

                    <div class="flex gap-3 w-full sm:w-auto">
                        <flux:button type="submit" variant="primary" icon="magnifying-glass" class="flex-1 sm:flex-none">Tampilkan Data</flux:button>
                        <flux:button href="{{ route('admin.reports.print', request()->all()) }}" target="_blank" icon="printer" variant="subtle" class="flex-1 sm:flex-none">Cetak Laporan</flux:button>
                    </div>
                </div>
            </form>
        </flux:card>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <flux:heading size="md">Preview Laporan</flux:heading>
                <flux:badge color="indigo" variant="subtle">{{ count($assets) }} Total Item</flux:badge>
            </div>
            
            <flux:card class="p-0 overflow-hidden">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column class="w-12">No</flux:table.column>
                        <flux:table.column>Kode Aset</flux:table.column>
                        <flux:table.column>Nama Barang</flux:table.column>
                        <flux:table.column>Kategori & Lokasi</flux:table.column>
                        <flux:table.column>Jumlah</flux:table.column>
                        <flux:table.column>Kondisi</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @forelse($assets as $index => $asset)
                        <flux:table.row>
                            <flux:table.cell>
                                <flux:text size="sm" class="text-zinc-400">{{ $index + 1 }}</flux:text>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:text size="sm" class="font-mono font-medium text-indigo-600 dark:text-indigo-400">{{ $asset->asset_code }}</flux:text>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:text size="sm" class="font-medium text-zinc-900 dark:text-white">{{ $asset->name }}</flux:text>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="flex flex-col">
                                    <flux:text size="sm">{{ $asset->category }}</flux:text>
                                    <flux:text size="xs" color="zinc">{{ $asset->location->name ?? '-' }}</flux:text>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:text size="sm" class="font-medium text-zinc-900 dark:text-white">{{ $asset->quantity }} <span class="font-normal text-zinc-500">{{ $asset->unit }}</span></flux:text>
                            </flux:table.cell>
                            <flux:table.cell>
                                @php
                                    $color = match($asset->condition) {
                                        'baik' => 'emerald',
                                        'cukup' => 'amber',
                                        'rusak' => 'red',
                                        default => 'zinc'
                                    };
                                @endphp
                                <flux:badge :color="$color" size="sm" variant="subtle">{{ ucfirst($asset->condition) }}</flux:badge>
                            </flux:table.cell>
                        </flux:table.row>
                        @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6">
                                <div class="flex flex-col items-center justify-center py-16">
                                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-full mb-4">
                                        <flux:icon.document-magnifying-glass class="size-8 text-zinc-400" />
                                    </div>
                                    <flux:heading size="lg">Data tidak ditemukan</flux:heading>
                                    <flux:subheading>Silakan sesuaikan filter untuk menampilkan data laporan.</flux:subheading>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </flux:container>
</x-layouts::app>
