<?php

use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/lw/tall-stack-ui', Livewire\TallStack::class);
Route::view('/tall-stack-ui', 'tall-stack-ui');
