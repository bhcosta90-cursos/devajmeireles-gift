<?php

declare(strict_types = 1);

arch('actions')
    ->expect('App\Action')
    ->toHaveMethod('handle');

arch('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

arch('facades')
    ->expect('Illuminate\Support\Facades')
    ->not->toBeUsed()->ignoring('App\Services\Facades');

arch('models')
    ->expect('App\Models')
    ->toExtend(Illuminate\Database\Eloquent\Model::class)
    ->ignoring('App\Models\Trait');
