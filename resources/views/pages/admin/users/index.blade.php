<x-layouts::app :title="__('Kelola Pengguna')">
    <flux:container class="py-8 space-y-6">

        {{-- ════════════════════════════════════════════════════════
        SECTION 1: PAGE HEADER
        ════════════════════════════════════════════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <flux:heading level="1" size="xl">Kelola Pengguna</flux:heading>
                <flux:subheading>Manajemen sistem operasional & akses kontrol</flux:subheading>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <flux:input icon="magnifying-glass" name="search" value="{{ request('search') }}"
                        placeholder="Cari user..." clearable size="sm" />
                </form>
                <flux:button :href="route('admin.users.create')" icon="plus" variant="primary" size="sm">
                    Tambah User
                </flux:button>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════
        SECTION 2: SUMMARY STATISTICS
        ════════════════════════════════════════════════════════ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Users --}}
            <flux:card class="!p-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-indigo-50 text-indigo-600">
                        <flux:icon.users class="size-5" />
                    </div>
                    <div>
                        <flux:text class="text-xs font-medium uppercase tracking-wider text-zinc-400">Total Users
                        </flux:text>
                        <div class="text-xl font-bold text-zinc-900">{{ $totalUsers }}</div>
                    </div>
                </div>
            </flux:card>

            {{-- Administrator --}}
            <flux:card class="!p-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-blue-50 text-blue-600">
                        <flux:icon.shield-check class="size-5" />
                    </div>
                    <div>
                        <flux:text class="text-xs font-medium uppercase tracking-wider text-zinc-400">Administrator
                        </flux:text>
                        <div class="text-xl font-bold text-zinc-900">{{ $adminCount }}</div>
                    </div>
                </div>
            </flux:card>

            {{-- Staf Operasional --}}
            <flux:card class="!p-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-amber-50 text-amber-600">
                        <flux:icon.user-group class="size-5" />
                    </div>
                    <div>
                        <flux:text class="text-xs font-medium uppercase tracking-wider text-zinc-400">Staf Operasional
                        </flux:text>
                        <div class="text-xl font-bold text-zinc-900">{{ $staffCount }}</div>
                    </div>
                </div>
            </flux:card>

            {{-- User Aktif --}}
            <flux:card class="!p-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center size-10 rounded-lg bg-emerald-50 text-emerald-600">
                        <flux:icon.check-circle class="size-5" />
                    </div>
                    <div>
                        <flux:text class="text-xs font-medium uppercase tracking-wider text-zinc-400">User Aktif
                        </flux:text>
                        <div class="text-xl font-bold text-zinc-900">{{ $activeCount }}</div>
                    </div>
                </div>
            </flux:card>
        </div>

        {{-- ════════════════════════════════════════════════════════
        SECTION 3: USER DATA TABLE
        ════════════════════════════════════════════════════════ --}}
        <flux:card class="!p-0 overflow-hidden">
            {{-- Table toolbar --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-zinc-100">
                <flux:heading size="sm">Daftar Pengguna</flux:heading>
                <div class="flex items-center gap-1 bg-zinc-100 rounded-lg p-0.5">
                    <button
                        class="px-3 py-1 text-xs font-medium rounded-md bg-white text-indigo-600 shadow-sm">Semua</button>
                    <button
                        class="px-3 py-1 text-xs font-medium rounded-md text-zinc-500 hover:text-zinc-700">Administrator</button>
                    <button
                        class="px-3 py-1 text-xs font-medium rounded-md text-zinc-500 hover:text-zinc-700">Staf</button>
                </div>
            </div>

            {{-- Data table --}}
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Informasi User</flux:table.column>
                    <flux:table.column>Akses Kontrol</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                    <flux:table.column class="text-right">Opsi</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($users as $user)
                        <flux:table.row>
                            {{-- User Info --}}
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex items-center justify-center size-9 rounded-full text-xs font-bold shrink-0
                                        {{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-zinc-100 text-zinc-600' }}">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-zinc-900 truncate">{{ $user->name }}</div>
                                        <div class="text-xs text-zinc-400 truncate">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </flux:table.cell>

                            {{-- Role Badge --}}
                            <flux:table.cell>
                                @if($user->isAdmin())
                                    <flux:badge color="indigo" size="sm" variant="pill">Administrator</flux:badge>
                                @else
                                    <flux:badge size="sm" variant="pill">Staf Operasional</flux:badge>
                                @endif
                            </flux:table.cell>

                            {{-- Status --}}
                            <flux:table.cell>
                                <div class="flex items-center gap-1.5">
                                    @if($user->is_active)
                                        <div class="size-1.5 rounded-full bg-emerald-500"></div>
                                        <span class="text-xs font-medium text-emerald-600">Aktif</span>
                                    @else
                                        <div class="size-1.5 rounded-full bg-zinc-300"></div>
                                        <span class="text-xs font-medium text-zinc-400">Non-Aktif</span>
                                    @endif
                                </div>
                            </flux:table.cell>

                            {{-- Actions --}}
                            <flux:table.cell class="text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <flux:button :href="route('admin.users.edit', $user)" variant="ghost" size="xs"
                                        icon="pencil-square" tooltip="Edit" />

                                    <flux:modal.trigger name="toggle-user-{{ $user->id }}">
                                        <flux:button variant="ghost" size="xs"
                                            icon="{{ $user->is_active ? 'no-symbol' : 'check-circle' }}"
                                            tooltip="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}" />
                                    </flux:modal.trigger>

                                    {{-- Toggle Confirmation Modal --}}
                                    <flux:modal name="toggle-user-{{ $user->id }}" class="md:w-96">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg">Konfirmasi Perubahan Status</flux:heading>
                                                <flux:subheading class="mt-1">
                                                    Anda akan {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} akun
                                                    <strong>{{ $user->name }}</strong>.
                                                </flux:subheading>
                                            </div>

                                            <div class="flex gap-2">
                                                <flux:modal.close class="flex-1">
                                                    <flux:button variant="ghost" class="w-full">Batal</flux:button>
                                                </flux:modal.close>

                                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST"
                                                    class="flex-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <flux:button type="submit" variant="primary" class="w-full">
                                                        Konfirmasi
                                                    </flux:button>
                                                </form>
                                            </div>
                                        </div>
                                    </flux:modal>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4">
                                <div class="flex flex-col items-center justify-center py-12 text-zinc-400">
                                    <flux:icon.users class="size-10 mb-3 opacity-30" />
                                    <p class="text-sm font-medium">Belum ada data pengguna</p>
                                    <p class="text-xs mt-1">Klik "Tambah User" untuk menambahkan pengguna baru.</p>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="flex justify-end">
                {{ $users->links() }}
            </div>
        @endif

    </flux:container>
</x-layouts::app>