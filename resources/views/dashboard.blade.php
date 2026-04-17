<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        
        <x-auth-session-status class="mb-4" :status="session('success') ?? session('error')" />

        @if(auth()->user()->isAdmin())
            <!-- Admin Dashboard -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Total Aset</flux:text>
                    <flux:heading size="xl">{{ $stats['total_assets'] ?? 0 }}</flux:heading>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Total Lokasi</flux:text>
                    <flux:heading size="xl">{{ $stats['total_locations'] ?? 0 }}</flux:heading>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Penggunaan Aset</flux:text>
                    <flux:heading size="xl">{{ $stats['total_usages'] ?? 0 }}</flux:heading>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Permintaan Stok</flux:text>
                    <flux:heading size="xl">{{ $stats['total_requests'] ?? 0 }}</flux:heading>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-2">
                <!-- Kondisi Aset -->
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:heading size="lg" class="mb-4">Kondisi Aset</flux:heading>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium">Baik</span>
                                <span>{{ $condition_stats['baik'] ?? 0 }}</span>
                            </div>
                            <flux:progress value="{{ ($stats['total_assets'] ?? 0) > 0 ? (($condition_stats['baik'] ?? 0) / $stats['total_assets']) * 100 : 0 }}" color="success" />
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium">Cukup</span>
                                <span>{{ $condition_stats['cukup'] ?? 0 }}</span>
                            </div>
                            <flux:progress value="{{ ($stats['total_assets'] ?? 0) > 0 ? (($condition_stats['cukup'] ?? 0) / $stats['total_assets']) * 100 : 0 }}" color="warning" />
                        </div>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium">Rusak</span>
                                <span>{{ $condition_stats['rusak'] ?? 0 }}</span>
                            </div>
                            <flux:progress value="{{ ($stats['total_assets'] ?? 0) > 0 ? (($condition_stats['rusak'] ?? 0) / $stats['total_assets']) * 100 : 0 }}" color="danger" />
                        </div>
                    </div>
                </div>

                <!-- Recent Requests -->
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="lg">Permintaan Terbaru</flux:heading>
                        <flux:badge color="warning">{{ $stats['pending_requests'] ?? 0 }} Menunggu</flux:badge>
                    </div>
                    
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @forelse($recent_requests as $request)
                            <div class="p-3 border border-neutral-100 dark:border-neutral-800 rounded-lg flex justify-between items-center bg-neutral-50 dark:bg-zinc-800">
                                <div>
                                    <div class="text-sm font-medium">{{ $request->requester->name }}</div>
                                    <div class="text-xs text-neutral-500">{{ $request->item_name }} ({{ $request->quantity }})</div>
                                </div>
                                <flux:badge size="sm" color="{{ $request->status === 'diajukan' ? 'warning' : ($request->status === 'disetujui' ? 'success' : 'danger') }}">
                                    {{ ucfirst($request->status) }}
                                </flux:badge>
                            </div>
                        @empty
                            <div class="text-sm text-neutral-500 italic py-4 text-center">Belum ada permintaan stok.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6 mt-2">
                <flux:heading size="lg" class="mb-4">Log Aktivitas Terbaru</flux:heading>
                <div class="space-y-4">
                    @forelse($recent_activities as $log)
                        <div class="flex gap-4">
                            <div class="mt-1 flex-none h-2 w-2 rounded-full bg-blue-500 ring-4 ring-blue-50 dark:ring-blue-900/20"></div>
                            <div>
                                <p class="text-sm">
                                    <span class="font-semibold">{{ $log->user ? $log->user->name : 'System' }}</span>
                                    <span>{{ $log->description }}</span>
                                </p>
                                <p class="text-xs text-neutral-400 mt-1">{{ $log->created_at->diffForHumans() }} • {{ $log->activity_type }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-neutral-500 italic">Belum ada aktivitas tercatat.</div>
                    @endforelse
                </div>
            </div>

        @else
            <!-- Staf Dashboard -->
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Aset Tersedia</flux:text>
                    <flux:heading size="xl">{{ $stats['available_assets'] ?? 0 }}</flux:heading>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Penggunaan Saya</flux:text>
                    <flux:heading size="xl">{{ $stats['my_usages'] ?? 0 }}</flux:heading>
                </div>
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6">
                    <flux:text class="mb-2 text-sm text-neutral-500">Permintaan Saya</flux:text>
                    <flux:heading size="xl">{{ $stats['my_requests'] ?? 0 }}</flux:heading>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2 mt-2">
                <!-- Usages -->
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="lg">Penggunaan Terakhir</flux:heading>
                    </div>
                    
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @forelse($recent_usages as $usage)
                            <div class="p-3 border border-neutral-100 dark:border-neutral-800 rounded-lg flex justify-between items-center bg-neutral-50 dark:bg-zinc-800">
                                <div>
                                    <div class="text-sm font-medium">{{ $usage->asset->name }}</div>
                                    <div class="text-xs text-neutral-500">{{ $usage->usage_date->format('d/m/Y') }}</div>
                                </div>
                                <div class="text-sm font-bold">{{ $usage->quantity }}</div>
                            </div>
                        @empty
                            <div class="text-sm text-neutral-500 italic py-4 text-center">Belum ada penggunaan tercatat.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Requests -->
                <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <flux:heading size="lg">Permintaan Stok</flux:heading>
                    </div>
                    
                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @forelse($recent_requests as $request)
                            <div class="p-3 border border-neutral-100 dark:border-neutral-800 rounded-lg flex justify-between items-center bg-neutral-50 dark:bg-zinc-800">
                                <div>
                                    <div class="text-sm font-medium">{{ $request->item_name }}</div>
                                    <div class="text-xs text-neutral-500">{{ $request->request_date->format('d/m/Y') }}</div>
                                </div>
                                <flux:badge size="sm" color="{{ $request->status === 'diajukan' ? 'warning' : ($request->status === 'disetujui' ? 'success' : 'danger') }}">
                                    {{ ucfirst($request->status) }}
                                </flux:badge>
                            </div>
                        @empty
                            <div class="text-sm text-neutral-500 italic py-4 text-center">Belum ada permintaan.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-layouts::app>
