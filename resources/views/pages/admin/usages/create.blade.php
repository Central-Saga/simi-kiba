<x-layouts::app :title="__('Catat Penggunaan Aset')">
    <flux:container class="max-w-3xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Catat Penggunaan</flux:heading>
                <flux:subheading>Catat aset mana yang sedang Anda gunakan</flux:subheading>
            </div>
            
            @php
                $backRoute = auth()->user()->isAdmin() ? route('admin.usages.index') : route('staf.usages.index');
            @endphp
            <flux:button :href="$backRoute" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        @php
            $storeRoute = auth()->user()->isAdmin() ? route('admin.usages.store') : route('staf.usages.store');
        @endphp
        <form action="{{ $storeRoute }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            
            <div class="space-y-6">
                <flux:select name="asset_id" label="Pilih Aset" searchable placeholder="Pilih Aset yang akan digunakan" required>
                    @foreach($assets as $asset)
                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                            {{ $asset->asset_code }} - {{ $asset->name }} (Tersedia: {{ $asset->quantity }} {{ $asset->unit }})
                        </option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input type="date" name="usage_date" label="Tanggal Penggunaan" value="{{ old('usage_date', date('Y-m-d')) }}" required />
                    <flux:input type="number" name="quantity" label="Jumlah" value="{{ old('quantity', 1) }}" min="1" required />
                </div>

                <flux:input name="purpose" label="Tujuan Penggunaan" value="{{ old('purpose') }}" placeholder="Contoh: Rapat Komisioner, Sidang Sengketa..." required />
                
                <flux:textarea name="notes" label="Catatan Tambahan (Opsional)" rows="3" placeholder="Keterangan tambahan...">{{ old('notes') }}</flux:textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <flux:button :href="$backRoute" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan Catatan</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>
