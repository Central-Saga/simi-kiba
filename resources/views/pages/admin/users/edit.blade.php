<x-layouts::app :title="__('Edit Pengguna')">
    <flux:container class="max-w-2xl space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Edit Pengguna</flux:heading>
                <flux:subheading>Perbarui informasi akun untuk {{ $user->name }}</flux:subheading>
            </div>
            <flux:button :href="route('admin.users.index')" variant="ghost" icon="chevron-left">Kembali</flux:button>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <flux:input name="name" label="Nama Lengkap" value="{{ old('name', $user->name) }}" required />
                
                <flux:input type="email" name="email" label="Alamat Email" value="{{ old('email', $user->email) }}" required />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:select name="role" label="Role / Peran" required>
                        <option value="staf_operasional" {{ old('role', $user->role) === 'staf_operasional' ? 'selected' : '' }}>Staf Operasional</option>
                        <option value="administrator" {{ old('role', $user->role) === 'administrator' ? 'selected' : '' }}>Administrator</option>
                    </flux:select>

                    <flux:select name="is_active" label="Status Akun">
                        <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Non-Aktif</option>
                    </flux:select>
                </div>
                
                <flux:separator variant="subtle" />

                <flux:text class="text-sm text-yellow-600 dark:text-yellow-500 font-medium flex items-center gap-2">
                    <flux:icon.information-circle class="size-5" />
                    Kosongkan kata sandi jika tidak ingin mengubahnya.
                </flux:text>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:input type="password" name="password" label="Kata Sandi Baru" />
                    <flux:input type="password" name="password_confirmation" label="Konfirmasi Sandi Baru" />
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <flux:button :href="route('admin.users.index')" variant="subtle">Batal</flux:button>
                <flux:button type="submit" variant="primary">Perbarui Pengguna</flux:button>
            </div>
        </form>
    </flux:container>
</x-layouts::app>

