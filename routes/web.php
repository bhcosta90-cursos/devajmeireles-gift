<?php

declare(strict_types = 1);

use App\Http\Controllers\ProfileController;
use App\Livewire;
use App\Models\{Category, Item, Setting};
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('items', Livewire\Admin\Items::class)->name('items')->can('viewAny', Item::class);
        Route::get('categories', Livewire\Admin\Categories::class)->name('categories')->can('viewAny', Category::class);
        Route::get('signatures', Livewire\Admin\Signatures::class)->name('signatures');
        Route::get('settings', Livewire\Admin\Settings::class)->name('settings')->can('viewAny', Setting::class);
    });
});

require __DIR__ . '/auth.php';
