<?php

declare(strict_types = 1);

use App\Action\Filter\SearchFilter;
use App\Models\{Category, Item};
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get(
        '/categories',
        fn (Category $category, SearchFilter $searchFilter) => $searchFilter->handle($category->active()->orderBy('name'))
    )->name('categories');

    Route::get(
        '/items',
        fn (Item $item, SearchFilter $searchFilter) => $searchFilter->handle($item->active()->orderBy('name'))
    )->name('items');
});
