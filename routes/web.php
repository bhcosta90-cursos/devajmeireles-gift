<?php

use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::get('/tall-stack-ui', Livewire\TallStack::class);
