<?php

declare(strict_types = 1);

use App\Models\{Category, Item};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/categories', fn (Category $category, Request $request) => $category
        ->active()
        ->orderBy('name')
        ->limit(30)
        ->search([
            'name' => [$request->get('search')],
        ])
        ->get()
        ->map(function (Category $category) {
            return [
                'id'   => $category->id,
                'name' => $category->name,
            ];
        })
        ->toArray())->name('categories');

    Route::get('/items', fn (Item $item, Request $request) => $item
        ->active()
        ->orderBy('name')
        ->search([
            'name' => [$request->get('search')],
        ])
        ->limit(30)
        ->get()
        ->map(function (Item $item) {
            return [
                'id'   => $item->id,
                'name' => $item->name,
            ];
        })
        ->toArray())->name('items');
});
