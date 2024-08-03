<?php

declare(strict_types = 1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Features\SupportTesting\Testable;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function mockAuthentication(bool $createdUser = false): User
{
    $user = User::factory()->make();

    if ($createdUser) {
        $user->save();
    }

    // Mock do guard e da autenticação
    $guard = Mockery::mock('Illuminate\Contracts\Auth\Guard');
    $guard->shouldReceive('check')->andReturn(true);
    $guard->shouldReceive('user')->andReturn($user);

    // Mock do facade Auth para usar o guard mockado
    Auth::shouldReceive('guard')->andReturn($guard);
    Auth::shouldReceive('shouldUse')->andReturnSelf();
    Auth::shouldReceive('userResolver')->andReturn(fn () => $user);
    Auth::shouldReceive('user')->andReturn($user);

    return $user;
}

Testable::macro('assertDelete', function (mixed $params) {
    return $this->assertConfirmation($params, 'delete');
});

Testable::macro('assertConfirmation', function (mixed $params, string $action) {
    $this->call($action, $params)
        ->assertDispatched(
            event: 'tallstackui:dialog',
            type: 'question',
            title: __('Warning!'),
            description: __('Are you sure?'),
            options: [
                "confirm" => [
                    "static" => false,
                    "text"   => __("Confirm"),
                    "method" => $actionDelete = "can" . ucfirst($action),
                    "params" => $params,
                ],
                "cancel" => [
                    "static" => false,
                    "text"   => __("Cancel"),
                    "method" => null,
                    "params" => null,
                ],
            ]
        )->call($actionDelete, $params);

    return $this;
});
