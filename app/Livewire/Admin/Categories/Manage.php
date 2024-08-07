<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Categories;

use App\Livewire\Traits\HasDialog;
use App\Models\Category;
use Arr;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Manage extends Component
{
    use HasDialog;

    public bool $slide = false;

    public ?Category $category = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?bool $active = true;

    public function render(): View
    {
        return view('livewire.admin.categories.manage');
    }

    public function updatedSlide(): void
    {
        $this->resetExcept('slide');
        $this->resetValidation();
    }

    #[On('manager::edit')]
    public function load(Category $category): void
    {
        $this->category = $category;

        $this->name   = $category->name;
        $this->active = $category->is_active;

        $this->slide = true;
    }

    public function save(): Category | bool
    {
        $data = Arr::except($this->validate(), 'active') + [
            'is_active' => $this->active,
        ];

        $response = $this->category
            ? $this->category->update($data)
            : Category::create($data);

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess();

        return $response;
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('categories', 'name')
                    ->whereNull('deleted_at')
                    ->ignore($this->category),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'active'      => ['required', 'boolean'],
        ];
    }
}
