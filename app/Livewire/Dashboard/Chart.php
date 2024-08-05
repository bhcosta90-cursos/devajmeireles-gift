<?php

declare(strict_types = 1);

namespace App\Livewire\Dashboard;

use App\Models\Signature;
use Carbon\{Carbon, CarbonInterval, CarbonPeriod};
use Livewire\Attributes\Computed;
use Livewire\Component;

class Chart extends Component
{
    public function render()
    {
        return view('livewire.dashboard.chart');
    }

    public function load(): void
    {
    }

    #[Computed]
    public function chart(): array
    {
        return collect($this->dates())
            ->merge($this->count())
            ->mapWithKeys(fn (int $value, string $date) => [
                Carbon::parse($date)->format('d/m') => $value,
            ])->toArray();

    }

    private function dates(): array
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

    private function count(): array
    {
        return Signature::query()
            ->selectRaw("DATE(created_at) as date, COUNT(*) as total")
            ->whereBetween("created_at", [
                now()->clone()->subMonthNoOverflow()->format('Y-m-d'),
                now()->format('Y-m-d'),
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }
}
