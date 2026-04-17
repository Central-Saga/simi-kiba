<x-layouts::app :title="__('Edit Lokasi')">
    <flux:container class="max-w-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Edit Lokasi</flux:heading>
                <flux:subheading>Perbarui informasi area atau ruangan {{ $location->code }}</flux:subheading>
            </div>
            <flux:button :href="route('admin.locations.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.locations.update', $location) }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <flux:input name="code" label="Kode Lokasi" value="{{ old('code', $location->code) }}" required />
                
                <flux:input name="name" label="Nama Lokasi" value="{{ old('name', $location->name) }}" required />
                
                <flux:textarea name="description" label="Deskripsi (Opsional)" rows="3">{{ old('description', $location->description) }}</flux:textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <flux:button :href="route('admin.locations.index')" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Perbarui Lokasi</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>
