<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Signatures;

use App\Models\Signature;
use Illuminate\View\View;
use Livewire\Component;

class Filter extends Component
{
    public bool $modal = false;

    public array $search = [
        'categories' => [],
        'created_at' => [],
        'items'      => [],
    ];

    public function mount(): void
    {
        $this->authorize('manage', Signature::class);

        $this->search['items']      = request('search.items', []);
        $this->search['categories'] = request('search.categories', []);
        $this->search['created_at'] = request('search.created_at', [
            Signature::orderBy('created_at')->first()?->created_at->format('Y-m-d') ?: now()->format('Y-m-d'),
            now()->format('Y-m-d'),
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.signatures.filter');
    }

    public function removeFilters(): void
    {
        $this->dispatch('filter::advanced', $this->search = collect($this->search)
            ->map(fn () => [])
            ->merge(['created_at' => $this->search['created_at']])
            ->toArray());
    }

    public function updatedSearch(): void
    {
        $this->dispatch('filter::advanced', $this->search);
    }
}
