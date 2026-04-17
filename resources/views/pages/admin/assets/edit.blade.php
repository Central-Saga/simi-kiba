<x-layouts::app :title="__('Edit Aset')">
    <flux:container class="max-w-4xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Edit Aset</flux:heading>
                <flux:subheading>Perbarui informasi inventaris aset untuk {{ $asset->asset_code }}</flux:subheading>
            </div>
            <flux:button :href="route('admin.assets.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.assets.update', $asset) }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <flux:input name="asset_code" label="Kode Aset" value="{{ old('asset_code', $asset->asset_code) }}" required />
                
                <flux:input name="name" label="Nama Aset" value="{{ old('name', $asset->name) }}" required />
                
                <flux:input name="category" label="Kategori" value="{{ old('category', $asset->category) }}" required />
                
                <flux:select name="location_id" label="Lokasi" required>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" {{ old('location_id', $asset->location_id) == $location->id ? 'selected' : '' }}>
                            {{ $location->code }} - {{ $location->name }}
                        </option>
                    @endforeach
                </flux:select>
                
                <flux:input type="number" name="quantity" label="Jumlah" value="{{ old('quantity', $asset->quantity) }}" min="0" required />
                
                <flux:input name="unit" label="Satuan" value="{{ old('unit', $asset->unit) }}" />
                
                <flux:select name="condition" label="Kondisi" required>
                    <option value="baik" {{ old('condition', $asset->condition) === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="cukup" {{ old('condition', $asset->condition) === 'cukup' ? 'selected' : '' }}>Cukup</option>
                    <option value="rusak" {{ old('condition', $asset->condition) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </flux:select>
            </div>

            <flux:textarea name="description" label="Deskripsi / Keterangan" rows="4">{{ old('description', $asset->description) }}</flux:textarea>

            <div class="mt-8 pt-6 flex items-center justify-end border-t border-neutral-200 dark:border-neutral-700 gap-3">
                <flux:button :href="route('admin.assets.index')" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Perbarui Aset</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>
