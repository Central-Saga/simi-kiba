<x-layouts::app :title="__('Detail Permintaan Stok')">
    <flux:container class="max-w-4xl space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <flux:heading level="1" size="xl">Detail Permintaan Stok</flux:heading>
                <flux:subheading>Tinjau permintaan pengadaan atau penambahan stok dari staf</flux:subheading>
            </div>
            <flux:button :href="route('admin.requests.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            {{-- Left Side: Request Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden shadow-sm">
                    <div class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="size-7 rounded-md bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center">
                                <flux:icon.clipboard-document-list class="size-4 text-zinc-500" />
                            </div>
                            <flux:heading size="sm">Informasi Permintaan</flux:heading>
                        </div>
                        
                        @if($stockRequest->status === 'diajukan')
                            <flux:badge color="warning" size="sm" icon="clock">Menunggu</flux:badge>
                        @elseif($stockRequest->status === 'disetujui')
                            <flux:badge color="success" size="sm" icon="check-circle">Disetujui</flux:badge>
                        @else
                            <flux:badge color="rose" size="sm" icon="x-circle">Ditolak</flux:badge>
                        @endif
                    </div>

                    <div class="p-6 space-y-8">
                        {{-- Items requested --}}
                        <div class="flex items-start gap-4">
                            <div class="size-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                                <flux:icon.archive-box class="size-6 text-indigo-500" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-1">BARANG YANG DIMINTA</p>
                                <flux:heading size="lg" class="text-zinc-900 dark:text-white">{{ $stockRequest->item_name }}</flux:heading>
                                <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">
                                    {{ $stockRequest->quantity }} <span class="text-sm font-medium text-zinc-500 uppercase">Unit/Item</span>
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Pemohon</p>
                                <div class="flex items-center gap-3">
                                    <flux:avatar :name="$stockRequest->requester->name" size="sm" />
                                    <div>
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $stockRequest->requester->name }}</p>
                                        <p class="text-xs text-zinc-500">{{ $stockRequest->requester->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Tanggal Pengajuan</p>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $stockRequest->request_date?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-2">Keterangan / Alasan Permintaan</p>
                            <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-100 dark:border-zinc-800">
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed italic">
                                    "{{ $stockRequest->notes ?? 'Tidak ada keterangan tambahan.' }}"
                                </p>
                            </div>
                        </div>

                        {{-- Approval Info (If not pending) --}}
                        @if($stockRequest->status !== 'diajukan')
                        <flux:separator variant="subtle" />
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 p-5 rounded-xl border border-zinc-100 dark:border-zinc-800">
                            <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-4">HASIL PENINJAUAN</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Peninjau</p>
                                    <div class="flex items-center gap-2">
                                        <flux:avatar :name="$stockRequest->approver->name ?? 'System'" size="xs" />
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $stockRequest->approver->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-1">Waktu Tinjauan</p>
                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $stockRequest->updated_at?->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Side: Decision Form --}}
            <div class="space-y-6">
                @if($stockRequest->status === 'diajukan')
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-5 shadow-sm">
                    <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-4 text-center">TINDAKAN PERSETUJUAN</p>
                    
                    <form action="{{ route('admin.requests.approve', $stockRequest) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <flux:textarea 
                            name="notes" 
                            label="Catatan Admin (Opsional)" 
                            placeholder="Alasan persetujuan atau instruksi tambahan..."
                            rows="4" 
                        />

                        <div class="space-y-2">
                            <flux:button type="submit" variant="primary" class="w-full" icon="check">Setujui Permintaan</flux:button>
                    </form>

                    <form action="{{ route('admin.requests.reject', $stockRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <flux:button type="submit" variant="danger" class="w-full" icon="x-mark">Tolak Permintaan</flux:button>
                    </form>
                </div>
                @else
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 text-center shadow-sm">
                    <div class="size-12 rounded-full mx-auto mb-4 flex items-center justify-center {{ $stockRequest->status === 'disetujui' ? 'bg-emerald-50 text-emerald-500 dark:bg-emerald-900/30' : 'bg-rose-50 text-rose-500 dark:bg-rose-900/30' }}">
                        <flux:icon.shield-check class="size-6" />
                    </div>
                    <flux:heading size="sm">Permintaan ini Selesai</flux:heading>
                    <p class="text-xs text-zinc-500 mt-2">Permintaan telah diproses dan status saat ini adalah kuncian permanen.</p>
                </div>
                @endif
                
                <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-dashed border-zinc-200 dark:border-zinc-800 rounded-xl p-5">
                    <p class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest mb-3">TIPS ADMIN</p>
                    <ul class="text-[11px] text-zinc-500 space-y-2 leading-relaxed">
                        <li>• Pastikan ketersediaan anggaran sebelum menyetujui.</li>
                        <li>• Periksa apakah barang serupa sudah ada di gudang lain melalui Mutasi Aset.</li>
                        <li>• Gunakan catatan admin untuk memberikan alasan jika permintaan ditolak.</li>
                    </ul>
                </div>
            </div>
        </div>

    </flux:container>
</x-layouts::app>
