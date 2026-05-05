<div class="flex min-h-screen">
    <!-- Left Side: Premium Visual -->
    <div class="hidden lg:flex lg:w-3/5 relative overflow-hidden bg-zinc-900">
        <!-- Background Overlay with Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-amber-600/90 via-zinc-900/95 to-black z-10"></div>

        <!-- Decorative Pattern / Image Placeholder -->
        <img src="https://images.unsplash.com/photo-1586769852044-692d6e3703f0?q=80&w=2000&auto=format&fit=crop"
            alt="Inventory Visual" class="absolute inset-0 h-full w-full object-cover opacity-40">

        <!-- Content -->
        <div class="relative z-20 flex flex-col justify-between p-16 h-full text-white">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-2xl border border-white/20 shadow-2xl">
                    <x-app-logo-icon class="size-8 fill-current text-white" />
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-black tracking-widest uppercase leading-none">SIMI</span>
                    <span
                        class="text-xs font-medium tracking-[0.3em] text-amber-400 uppercase leading-none mt-1">Management
                        System</span>
                </div>
            </div>

            <div class="max-w-2xl">
                <div
                    class="inline-flex items-center px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/30 text-amber-400 text-xs font-bold uppercase tracking-widest mb-6">
                    Sistem Informasi Manajemen Inventaris
                </div>
                <h1 class="text-7xl font-black leading-[0.9] mb-8 tracking-tighter">
                    KOMISI<br>
                    INFORMASI<br>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600 italic">BALI</span>
                </h1>
                <p class="text-xl text-zinc-400 leading-relaxed max-w-lg">
                    Platform terintegrasi untuk pengelolaan aset dan inventaris negara dengan presisi, transparansi, dan
                    efisiensi tingkat tinggi.
                </p>
            </div>

            <div class="flex items-center gap-6 text-sm font-medium text-zinc-500">
                <span>&copy; {{ date('Y') }} Komisi Informasi Bali</span>
                <span class="h-1 w-1 rounded-full bg-zinc-700"></span>
                <span>Security Verified</span>
            </div>
        </div>

        <!-- Abstract Decorative Elements -->
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-amber-600/20 rounded-full blur-[120px] z-0"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-900/20 rounded-full blur-[120px] z-0"></div>
    </div>

    <!-- Right Side: Clean Login Form -->
    <div class="w-full lg:w-2/5 flex items-center justify-center p-8 sm:p-16 bg-white dark:bg-zinc-950">
        <div class="w-full max-w-sm">
            <!-- Mobile Logo -->
            <div class="lg:hidden mb-12 flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-600 text-white shadow-lg">
                    <x-app-logo-icon class="size-7 fill-current" />
                </div>
                <span class="text-xl font-bold tracking-tight uppercase">SIMI KIB</span>
            </div>

            <div class="mb-12">
                <h2 class="text-4xl font-extrabold text-zinc-900 dark:text-white tracking-tight mb-3">Login Admin</h2>
                <p class="text-zinc-500 dark:text-zinc-400">Silakan masukkan kredensial Anda untuk mengakses panel
                    kontrol.</p>
            </div>

            <!-- Filament Form Content (v5 Schema) -->
            <div class="fi-auth-form-container">
                {{ $this->content }}
            </div>

            <!-- <div class="mt-8 pt-8 border-t border-zinc-100 dark:border-zinc-800 flex justify-center">
                 <a href="{{ route('home') }}" class="text-sm font-medium text-zinc-500 hover:text-amber-600 transition-colors flex items-center gap-2">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Beranda
                 </a>
            </div> -->
        </div>
    </div>
</div>

<style>
    /* Premium overrides and Safety Styles */
    body {
        overflow-x: hidden !important;
    }

    .fi-auth-form-container form {
        @apply space-y-6 !important;
    }

    .fi-btn {
        @apply h-12 text-base font-bold tracking-wide shadow-xl transition-all active:scale-[0.98] !important;
        background-color: #d97706 !important;
        /* Amber-600 */
        color: white !important;
    }

    .fi-btn:hover {
        background-color: #b45309 !important;
        /* Amber-700 */
    }

    .fi-input-wrp {
        @apply bg-zinc-50 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 rounded-xl transition-all !important;
    }

    .fi-input-wrp:focus-within {
        @apply ring-2 ring-amber-500/20 border-amber-500 !important;
    }

    /* Safety if Tailwind build is not synced yet */
    h1 {
        line-height: 1 !important;
    }

    .lg\:w-3\/5 {
        width: 60% !important;
    }

    .lg\:w-2\/5 {
        width: 40% !important;
    }
</style>