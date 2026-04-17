<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white font-sans antialiased" style="background-color: #f8f9fb;">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50">
            <flux:sidebar.header>
                <div class="flex items-center gap-2.5">
                    <div class="flex items-center justify-center size-7 rounded-md bg-indigo-600 shadow-sm">
                        <flux:icon.cube class="size-4 text-white" />
                    </div>
                    <span class="text-sm font-semibold text-zinc-900 tracking-tight">Laravel Starter Kit</span>
                </div>
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>

                @if(auth()->user()->isAdmin())
                    <flux:sidebar.group :heading="__('Data Master')" class="grid">
                        <flux:sidebar.item icon="users" :href="route('admin.users.index')" :current="request()->routeIs('admin.users.*')" wire:navigate>
                            Pengguna
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="shield-check" :href="route('admin.roles.index')" :current="request()->routeIs('admin.roles.*')" wire:navigate>
                            Roles & Permissions
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="map-pin" :href="route('admin.locations.index')" :current="request()->routeIs('admin.locations.*')" wire:navigate>
                            Lokasi
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif

                <flux:sidebar.group :heading="__('Inventaris')" class="grid">
                    @php
                        $assetsRoute = auth()->user()->isAdmin() ? route('admin.assets.index') : route('staf.assets.index');
                        $assetsActive = auth()->user()->isAdmin() ? request()->routeIs('admin.assets.*') : request()->routeIs('staf.assets.*');
                    @endphp
                    <flux:sidebar.item icon="archive-box" :href="$assetsRoute" :current="$assetsActive" wire:navigate>
                        Aset Inventaris
                    </flux:sidebar.item>

                    @php
                        $usagesRoute = auth()->user()->isAdmin() ? route('admin.usages.index') : route('staf.usages.index');
                        $usagesActive = auth()->user()->isAdmin() ? request()->routeIs('admin.usages.*') : request()->routeIs('staf.usages.*');
                    @endphp
                    <flux:sidebar.item icon="clock" :href="$usagesRoute" :current="$usagesActive" wire:navigate>
                        Penggunaan Aset
                    </flux:sidebar.item>

                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.item icon="arrows-right-left" :href="route('admin.mutations.index')" :current="request()->routeIs('admin.mutations.*')" wire:navigate>
                            Mutasi Aset
                        </flux:sidebar.item>
                    @endif

                    @php
                        $requestsRoute = auth()->user()->isAdmin() ? route('admin.requests.index') : route('staf.requests.index');
                        $requestsActive = auth()->user()->isAdmin() ? request()->routeIs('admin.requests.*') : request()->routeIs('staf.requests.*');
                    @endphp
                    <flux:sidebar.item icon="clipboard-document-list" :href="$requestsRoute" :current="$requestsActive" wire:navigate>
                        Permintaan Stok
                    </flux:sidebar.item>
                </flux:sidebar.group>

                @if(auth()->user()->isAdmin())
                    <flux:sidebar.group :heading="__('Laporan & Sistem')" class="grid">
                        <flux:sidebar.item icon="document-text" :href="route('admin.reports.index')" :current="request()->routeIs('admin.reports.*')" wire:navigate>
                            Laporan
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="clock" :href="route('admin.logs.index')" :current="request()->routeIs('admin.logs.*')" wire:navigate>
                            Log Aktivitas
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="book-open" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
