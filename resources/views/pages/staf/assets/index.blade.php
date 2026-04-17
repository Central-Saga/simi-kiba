@extends('layouts.main')

@section('header_title', 'Daftar Inventaris Aset')

@section('content')
<!-- Filter & Search Section -->
<div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm mb-6">
    <form action="{{ route('staf.assets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cari Aset</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="block w-full border-slate-300 rounded-lg text-sm transition-all focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Kode atau nama...">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
            <select name="category" class="block w-full border-slate-300 rounded-lg text-sm transition-all focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kondisi</label>
            <select name="condition" class="block w-full border-slate-300 rounded-lg text-sm transition-all focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Kondisi</option>
                <option value="baik" {{ request('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="cukup" {{ request('condition') == 'cukup' ? 'selected' : '' }}>Cukup</option>
                <option value="rusak" {{ request('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>
        <div class="flex items-end space-x-2">
            <button type="submit" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-white text-sm hover:bg-indigo-700 transition-all">
                Filter
            </button>
            <a href="{{ route('staf.assets.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 border border-transparent rounded-lg font-bold text-slate-600 text-sm hover:bg-slate-200 transition-all">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aset</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori & Lokasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tersedia</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kondisi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($assets as $asset)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-700">{{ $asset->asset_code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-900">{{ $asset->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs font-medium text-slate-500">{{ $asset->category }}</div>
                        <div class="text-xs text-indigo-600 font-bold">{{ $asset->location->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-900">{{ $asset->quantity }} {{ $asset->unit }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($asset->condition === 'baik')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase">Baik</span>
                        @elseif($asset->condition === 'cukup')
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">Cukup</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 uppercase">Rusak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <a href="{{ route('staf.assets.show', $asset) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-bold" title="Detail">
                            Detail
                            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400 italic">Data aset tidak tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($assets->hasPages())
    <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
        {{ $assets->links() }}
    </div>
    @endif
</div>
@endsection
