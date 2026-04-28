<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return redirect()->route('filament.admin.pages.dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
