<?php

declare(strict_types = 1);

use App\Http\Controllers\ProfileController;
use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/tall-stack-ui', Livewire\TallStack::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('items', Livewire\Admin\Items::class)->name('items');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
