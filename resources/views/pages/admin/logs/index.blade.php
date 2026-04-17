<x-layouts::app :title="__('Log Aktivitas Sistem')">
    <flux:container class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Log Aktivitas Sistem</flux:heading>
                <flux:subheading>Pantau seluruh aktivitas pengguna dan perubahan data di dalam sistem</flux:subheading>
            </div>
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Waktu</flux:table.column>
                <flux:table.column>Pengguna</flux:table.column>
                <flux:table.column>Aktivitas</flux:table.column>
                <flux:table.column>Keterangan</flux:table.column>
                <flux:table.column>Alamat IP</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($logs as $log)
                <flux:table.row>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-500 font-medium">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="font-medium text-sm text-zinc-900 dark:text-white">{{ $log->user->name ?? 'System' }}</div>
                        <div class="text-xs text-zinc-500 capitalize">{{ $log->user->role ?? '-' }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="indigo" size="sm" class="uppercase">{{ $log->activity_type }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-sm text-zinc-600 dark:text-zinc-300 max-w-md truncate">{{ $log->description }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-xs text-zinc-400 font-mono">{{ $log->ip_address }}</div>
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5">
                        <div class="flex flex-col items-center justify-center py-10">
                            <flux:icon.clock class="size-10 text-zinc-300 dark:text-zinc-600 mb-3" />
                            <flux:subheading>Belum ada aktivitas yang tercatat.</flux:subheading>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        @if($logs->hasPages())
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
        @endif
    </flux:container>
</x-layouts::app>
