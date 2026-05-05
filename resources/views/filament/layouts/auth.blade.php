@vite(['resources/css/app.css'])
<x-filament-panels::layout.base :livewire="$livewire">
    <div class="fi-auth-layout min-h-screen bg-white dark:bg-zinc-950">
        {{ $slot }}
    </div>
</x-filament-panels::layout.base>

<style>
    /* Reset Filament constraints for full-screen layout */
    .fi-simple-main-ctn, .fi-simple-main {
        max-width: none !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
    }
</style>
