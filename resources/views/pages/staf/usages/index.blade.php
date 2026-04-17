@extends('layouts.main')

@section('header_title', 'Riwayat Penggunaan Aset Saya')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
    <div class="relative flex-1 max-w-md">
        <form action="{{ route('staf.usages.index') }}" method="GET">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all"
                placeholder="Cari nama aset...">
        </form>
    </div>
    <a href="{{ route('staf.usages.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Catat Penggunaan
    </a>
</div>

<div class="bg-white shadow-sm border border-slate-200 rounded-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aset</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tujuan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-100">
                @forelse($usages as $usage)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-slate-900">{{ $usage->asset->name }}</div>
                        <div class="text-xs text-indigo-600 font-bold uppercase">{{ $usage->asset->asset_code }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">{{ $usage->usage_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">{{ $usage->quantity }} {{ $usage->asset->unit }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate">{{ $usage->purpose }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">Anda belum mencatat penggunaan aset.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($usages->hasPages())
    <div class="bg-slate-50/50 px-6 py-4 border-t border-slate-100">
        {{ $usages->links() }}
    </div>
    @endif
</div>
@endsection
