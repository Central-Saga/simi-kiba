<x-layouts::app :title="__('Daftar Permintaan Stok')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Permintaan Stok</flux:heading>
                <flux:subheading>Kelola persetujuan permintaan stok dari staf</flux:subheading>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
            <form action="{{ route('admin.requests.index') }}" method="GET" class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="w-full sm:w-64">
                    <flux:select name="status" label="Filter Status" class="w-full">
                        <option value="">Semua Status</option>
                        <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </flux:select>
                </div>
                <div class="flex items-center gap-2">
                    <flux:button type="submit" variant="primary">Filter</flux:button>
                    @if(request('status'))
                        <flux:button :href="route('admin.requests.index')" variant="subtle">Reset</flux:button>
                    @endif
                </div>
            </form>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Pemohon</flux:table.column>
                <flux:table.column>Barang</flux:table.column>
                <flux:table.column>Tanggal</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column align="right">Aksi</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($requests as $request)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-900 dark:text-white">{{ $request->requester->name }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-700 dark:text-zinc-300">{{ $request->item_name }}</div>
                        <div class="text-xs text-zinc-500">Jumlah: {{ $request->quantity }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-700 dark:text-zinc-300 font-medium">{{ $request->request_date->format('d M Y') }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        @if($request->status === 'diajukan')
                            <flux:badge color="warning" size="sm">Diajukan</flux:badge>
                        @elseif($request->status === 'disetujui')
                            <flux:badge color="success" size="sm">Disetujui</flux:badge>
                        @else
                            <flux:badge color="danger" size="sm">Ditolak</flux:badge>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell align="right">
                        <flux:button :href="route('admin.requests.show', $request)" size="sm" icon="eye" variant="ghost" inset="top bottom" />
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5">
                        <div class="flex flex-col items-center justify-center py-10">
                            <flux:icon.clipboard-document-list class="size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                            <flux:subheading>Belum ada permintaan stok.</flux:subheading>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($requests->hasPages())
        <div class="mt-4">
            {{ $requests->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
