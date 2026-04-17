<x-layouts::app :title="__('Catat Mutasi Aset')">
    <flux:container class="max-w-3xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Catat Mutasi</flux:heading>
                <flux:subheading>Pindahkan aset inventaris ke lokasi yang baru</flux:subheading>
            </div>
            <flux:button :href="route('admin.mutations.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.mutations.store') }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Aset -->
                <div>
                    <label for="asset_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Pilih Aset</label>
                    <select name="asset_id" id="asset_id" required class="block w-full rounded-md border-0 py-1.5 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700">
                        <option value="">Pilih Aset yang akan dimutasi</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }} data-location="{{ $asset->location_id }}">
                                {{ $asset->asset_code }} - {{ $asset->name }} (Lokasi Saat Ini: {{ $asset->location->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lokasi Asal -->
                    <div>
                        <label for="from_location_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Lokasi Asal</label>
                        <select name="from_location_id" id="from_location_id" required class="block w-full rounded-md border-0 py-1.5 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 bg-zinc-50 dark:bg-zinc-900" readonly>
                            <option value="">Pilih Lokasi Asal</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('from_location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lokasi Tujuan -->
                    <div>
                        <label for="to_location_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Lokasi Tujuan</label>
                        <select name="to_location_id" id="to_location_id" required class="block w-full rounded-md border-0 py-1.5 text-zinc-900 shadow-sm ring-1 ring-inset ring-zinc-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700">
                            <option value="">Pilih Lokasi Tujuan</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('to_location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input type="date" name="mutation_date" label="Tanggal Mutasi" value="{{ old('mutation_date', date('Y-m-d')) }}" required />
                    <flux:input type="number" name="quantity" label="Jumlah" value="{{ old('quantity', 1) }}" min="1" required />
                </div>

                <flux:textarea name="notes" label="Catatan / Alasan Mutasi (Opsional)" rows="3" placeholder="Keterangan tambahan mutasi...">{{ old('notes') }}</flux:textarea>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <flux:button :href="route('admin.mutations.index')" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Proses Mutasi</flux:button>
            </div>
        </form>
    </flux:container>

    <script>
        document.getElementById('asset_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const locationId = option.getAttribute('data-location');
            if (locationId) {
                document.getElementById('from_location_id').value = locationId;
            }
        });
    </script>
</x-layouts::app>
