<x-layouts::app :title="__('Tambah Aset Baru')">
    <flux:container class="max-w-4xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Tambah Aset Baru</flux:heading>
                <flux:subheading>Masukkan informasi inventaris aset ke dalam sistem</flux:subheading>
            </div>
            <flux:button :href="route('admin.assets.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.assets.store') }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <flux:input name="asset_code" label="Kode Aset" value="{{ old('asset_code') }}" placeholder="Contoh: AST-001..." required />
                
                <flux:input name="name" label="Nama Aset" value="{{ old('name') }}" placeholder="Nama barang / aset..." required />
                
                <flux:input name="category" label="Kategori" value="{{ old('category') }}" placeholder="Contoh: Elektronik, Mebel..." required />
                
                <flux:select name="location_id" label="Lokasi" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                            {{ $location->code }} - {{ $location->name }}
                        </option>
                    @endforeach
                </flux:select>
                
                <flux:input type="number" name="quantity" label="Jumlah" value="{{ old('quantity', 0) }}" min="0" required />
                
                <flux:input name="unit" label="Satuan" value="{{ old('unit', 'Unit') }}" placeholder="Contoh: Unit, Set, Pcs..." />
                
                <flux:select name="condition" label="Kondisi" required>
                    <option value="baik" {{ old('condition') === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup" {{ old('condition') === 'cukup' ? 'selected' : '' }}>Cukup</option>
                    <option value="rusak" {{ old('condition') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </flux:select>
            </div>

            <flux:textarea name="description" label="Deskripsi / Keterangan (Opsional)" rows="4" placeholder="Informasi detail aset...">{{ old('description') }}</flux:textarea>

            <div class="mt-8 pt-6 flex items-center justify-end border-t border-neutral-200 dark:border-neutral-700 gap-3">
                <flux:button :href="route('admin.assets.index')" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Simpan Aset</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>
