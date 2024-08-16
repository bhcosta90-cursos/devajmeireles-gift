<?php

declare(strict_types = 1);

namespace App\Livewire\Frontend;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public ?Collection $categories = null;

    public ?Category $filterCategory = null;

    public ?Collection $items = null;

    public bool $filtered = false;

    public int $limit = 9;

    public array $search = [
        'name' => [],
    ];

    public function render(): View
    {
        return view('livewire.frontend.index');
    }

    public function category(): void
    {
        $this->reset('filtered', 'limit', 'search');

        $this->categories = Category::with('items')
            ->withCount(['items' => fn (Builder $query) => $query->active()]) // @phpstan-ignore-line
            ->active()
            ->oldest('name')
            ->get();
    }

    #[On('frontend::load::more')]
    public function item(Category $category): void
    {
        $this->filtered       = true;
        $this->filterCategory = $category;

        $this->items = $this->filterCategory->items()
            ->search($this->search)
            ->with('signatures')
            ->active()
            ->take($this->limit)
            ->oldest('name')
            ->get();
    }

    public function more(): void
    {
        $this->limit += 9;
        $this->item($this->filterCategory);
    }
}
