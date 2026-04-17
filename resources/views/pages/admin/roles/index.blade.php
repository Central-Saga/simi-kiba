<x-layouts::app :title="__('Roles & Permissions')">
    <flux:container class="space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <flux:heading level="1" size="xl">Roles & Permissions</flux:heading>
                <flux:subheading>Kelola peran pengguna dan hak akses pada sistem</flux:subheading>
            </div>
            <flux:badge color="indigo" size="lg" icon="shield-check">
                {{ $roles->count() }} Role Aktif
            </flux:badge>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl">
            <flux:icon.check-circle class="size-5 text-emerald-500 shrink-0" />
            <p class="text-sm text-emerald-700 dark:text-emerald-300">{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="flex items-center gap-3 px-4 py-3 bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700 rounded-xl">
            <flux:icon.x-circle class="size-5 text-rose-500 shrink-0" />
            <p class="text-sm text-rose-700 dark:text-rose-300">{{ session('error') }}</p>
        </div>
        @endif

        {{-- 2-Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- LEFT: Daftar Role --}}
            <div class="lg:col-span-2 space-y-3">
                <div class="flex items-center justify-between">
                    <flux:heading size="sm" class="text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Daftar Role
                    </flux:heading>
                    <span class="text-xs text-zinc-400">{{ $roles->count() }} entri</span>
                </div>

                @forelse($roles as $role)
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                    {{-- Role Header --}}
                    <div class="flex items-center justify-between px-5 py-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="flex items-center justify-center size-9 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 shrink-0">
                                <flux:icon.shield-check class="size-5 text-indigo-500 dark:text-indigo-400" />
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-sm text-zinc-900 dark:text-white capitalize truncate">
                                    {{ $role->name }}
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $role->users_count }} pengguna
                                    <span class="mx-1 text-zinc-300 dark:text-zinc-600">&bull;</span>
                                    {{ $role->permissions->count() }} permission
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if(in_array($role->name, ['admin', 'staf']))
                                <flux:badge color="indigo" size="sm">Sistem</flux:badge>
                            @else
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button
                                        type="submit"
                                        size="sm"
                                        variant="ghost"
                                        icon="trash"
                                        class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-900/20"
                                        onclick="return confirm('Yakin ingin menghapus role: {{ $role->name }}?')"
                                    />
                                </form>
                            @endif
                        </div>
                    </div>

                    <flux:separator variant="subtle" />

                    {{-- Permission Editor --}}
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="p-5">
                        @csrf
                        @method('PUT')

                        <p class="text-xs font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mb-3">
                            Permissions yang Dimiliki
                        </p>

                        @if($permissions->isEmpty())
                            <p class="text-sm text-zinc-400 italic">Belum ada permission yang terdaftar di sistem.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-x-4 gap-y-2 mb-4">
                                @foreach($permissions as $permission)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                        class="size-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800"
                                    >
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $permission->name }}
                                    </span>
                                </label>
                                @endforeach
                            </div>

                            <div class="flex justify-end pt-2 border-t border-zinc-100 dark:border-zinc-800">
                                <flux:button type="submit" variant="primary" size="sm" icon="check">
                                    Simpan Permissions
                                </flux:button>
                            </div>
                        @endif
                    </form>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-16 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl text-center">
                    <div class="size-14 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                        <flux:icon.shield-exclamation class="size-7 text-zinc-400 dark:text-zinc-500" />
                    </div>
                    <flux:heading size="sm">Belum ada role</flux:heading>
                    <flux:subheading class="mt-1 text-sm">Tambahkan role pertama menggunakan form di sebelah kanan.</flux:subheading>
                </div>
                @endforelse
            </div>

            {{-- RIGHT: Form + Permissions Registry --}}
            <div class="space-y-4">

                {{-- Add Role Form --}}
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center gap-2">
                        <div class="size-7 rounded-md bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                            <flux:icon.plus class="size-4 text-indigo-500" />
                        </div>
                        <flux:heading size="sm">Tambah Role Baru</flux:heading>
                    </div>

                    <form action="{{ route('admin.roles.store') }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        <div>
                            <flux:input
                                name="name"
                                label="Nama Role"
                                placeholder="Contoh: supervisor, auditor..."
                                value="{{ old('name') }}"
                                required
                            />
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($permissions->isNotEmpty())
                        <div>
                            <p class="text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-2">
                                Permissions Awal
                                <span class="font-normal normal-case text-zinc-400">(opsional)</span>
                            </p>
                            <div class="space-y-1.5 max-h-44 overflow-y-auto pr-1">
                                @foreach($permissions as $permission)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                        class="size-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-600 dark:bg-zinc-800"
                                    >
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400 group-hover:text-indigo-600 transition-colors">
                                        {{ $permission->name }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <flux:button type="submit" variant="primary" class="w-full" icon="plus">
                            Buat Role
                        </flux:button>
                    </form>
                </div>

                {{-- Permissions Registry --}}
                <div class="bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl overflow-hidden">
                    <div class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="size-7 rounded-md bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center">
                                <flux:icon.key class="size-4 text-zinc-500" />
                            </div>
                            <flux:heading size="sm">Semua Permissions</flux:heading>
                        </div>
                        <flux:badge color="zinc" size="sm">{{ $permissions->count() }}</flux:badge>
                    </div>

                    <div class="p-5">
                        @if($permissions->isEmpty())
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <flux:icon.key class="size-8 text-zinc-300 dark:text-zinc-600 mb-2" />
                                <p class="text-sm text-zinc-400 italic">Belum ada permission di sistem.</p>
                            </div>
                        @else
                        <div class="space-y-1 max-h-60 overflow-y-auto">
                            @foreach($permissions as $permission)
                            <div class="flex items-center gap-2 py-1.5 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                                <flux:icon.key class="size-3.5 text-zinc-400 shrink-0" />
                                <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $permission->name }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </flux:container>
</x-layouts::app>
