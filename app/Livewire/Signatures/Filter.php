<?php

declare(strict_types = 1);

namespace App\Livewire\Signatures;

use App\Models\Signature;
use Illuminate\View\View;
use Livewire\Component;

class Filter extends Component
{
    public bool $modal = false;

    public array $search = [
        'categories' => [],
        'created_at' => [],
    ];

    public function mount(): void
    {
        $this->search['categories'] = request('search.categories', []);
        $this->search['created_at'] = request('search.created_at', [
            Signature::orderBy('created_at')->first()->created_at->format('Y-m-d'),
            now()->format('Y-m-d'),
        ]);
    }

    public function render(): View
    {
        return view('livewire.signatures.filter');
    }

    public function updatedSearch(): void
    {
        $this->dispatch('filter::advanced', $this->search);
    }
}