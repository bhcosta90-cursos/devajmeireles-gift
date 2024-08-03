<?php

declare(strict_types = 1);

namespace App\View\Components\Models;

use App\Models\Category as ModelCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Category extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $name = 'category')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.models.category');
    }

    public function listCategories(): array
    {
        return ModelCategory::query()
            ->active()
            ->get()
            ->map(function (ModelCategory $category) {
                return [
                    'value' => $category->id,
                    'label' => $category->name,
                ];
            })
            ->toArray();
    }
}
