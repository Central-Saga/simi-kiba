@extends('layouts.main')

@section('header_title', 'Catat Penggunaan Aset')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ Auth::user()->isAdmin() ? route('admin.usages.index') : route('staf.usages.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Riwayat
        </a>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <form action="{{ Auth::user()->isAdmin() ? route('admin.usages.store') : route('staf.usages.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Aset -->
                <div>
                    <label for="asset_id" class="block text-sm font-bold text-slate-700 mb-1">Pilih Aset</label>
                    <select name="asset_id" id="asset_id" required class="block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Aset yang akan digunakan</option>
                        @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                {{ $asset->asset_code }} - {{ $asset->name }} (Tersedia: {{ $asset->quantity }} {{ $asset->unit }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="usage_date" class="block text-sm font-bold text-slate-700 mb-1">Tanggal Penggunaan</label>
                        <input type="date" name="usage_date" id="usage_date" value="{{ old('usage_date', date('Y-m-d')) }}" required
                            class="block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('usage_date')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="quantity" class="block text-sm font-bold text-slate-700 mb-1">Jumlah</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" required
                            class="block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('quantity')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tujuan -->
                <div>
                    <label for="purpose" class="block text-sm font-bold text-slate-700 mb-1">Tujuan Penggunaan</label>
                    <input type="text" name="purpose" id="purpose" value="{{ old('purpose') }}" required
                        class="block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Contoh: Rapat Komisioner, Sidang Sengketa...">
                    @error('purpose')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div>
                    <label for="notes" class="block text-sm font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Keterangan tambahan..."></textarea>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <button type="submit" class="inline-flex justify-center py-2.5 px-8 border border-transparent shadow-sm text-sm font-bold rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Simpan Catatan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
