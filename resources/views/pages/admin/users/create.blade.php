<x-layouts::app :title="__('Tambah Pengguna Baru')">
    <flux:container class="max-w-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Tambah Pengguna Baru</flux:heading>
                <flux:subheading>Buat akun administrator atau staf operasional baru</flux:subheading>
            </div>
            <flux:button :href="route('admin.users.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            
            <div class="space-y-6">
                <flux:input name="name" label="Nama Lengkap" value="{{ old('name') }}" placeholder="Contoh: John Doe" required />
                
                <flux:input type="email" name="email" label="Alamat Email" value="{{ old('email') }}" placeholder="email@example.com" required />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:select name="role" label="Role / Peran" required>
                        <option value="staf_operasional" {{ old('role') === 'staf_operasional' ? 'selected' : '' }}>Staf Operasional</option>
                        <option value="administrator" {{ old('role') === 'administrator' ? 'selected' : '' }}>Administrator</option>
                    </flux:select>

                    <flux:select name="is_active" label="Status Akun">
                        <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                    </flux:select>
                </div>
                
                <flux:separator variant="subtle" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input type="password" name="password" label="Kata Sandi" placeholder="Minimal 8 karakter" required />
                    <flux:input type="password" name="password_confirmation" label="Konfirmasi Sandi" placeholder="Ulangi kata sandi" required />
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <flux:button type="reset" variant="subtle">Reset</flux:button>
                <flux:button type="submit" variant="primary">Simpan Pengguna</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>
