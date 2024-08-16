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
    ->not->toBeUsed();

arch('models')
    ->expect('App\Models')
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->ignoring('App\Models\Trait');
