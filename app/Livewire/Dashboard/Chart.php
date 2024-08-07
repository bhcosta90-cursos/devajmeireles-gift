<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use App\Enums\SecondsType;
use App\Models\Signature;
use Cache;
use Carbon\{Carbon, CarbonInterval, CarbonPeriod};
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{Isolate};
use Livewire\Component;

#[Isolate]
class Chart extends Component
{
    public array $chart = [];

    public function render(): View
    {
        return view('livewire.dashboard.chart');
    }

    public function load(): void
    {
        $this->chart = collect($this->dates())
            ->merge($this->count())
            ->mapWithKeys(fn (int $value, string $date) => [
                Carbon::parse($date)->format('d/m') => $value,
            ])->toArray();
    }

    protected function dates(): array
    {
        $period = new CarbonPeriod(
            now()->subMonthNoOverflow(),
            now(),
            CarbonInterval::days()
        );

        return collect($period->toArray())
            ->mapWithKeys(fn (Carbon $date) => [$date->format('Y-m-d') => 0]) // @phpstan-ignore-line
            ->toArray();
    }

    protected function count(): array
    {
        return Cache::remember(
            key: 'chart',
            ttl: SecondsType::Minute->value * 5,
            callback: fn () => Signature::query()
                ->selectRaw("DATE(created_at) as date, COUNT(*) as total")
                ->whereBetween("created_at", [
                    now()->clone()->subMonthNoOverflow()->format('Y-m-d'),
                    now()->format('Y-m-d'),
                ])
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date')
                ->toArray()
        );
    }
}
