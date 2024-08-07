<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\HasDialog;
use App\Models\Setting;
use App\Services\Facades\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use HasDialog;

    public bool $slide = false;

    public ?string $key = null;

    public ?string $type = null;

    public ?string $value = null;

    public function mount(): void
    {
        $this->authorize('create', Setting::class);
    }

    public function render(): View
    {
        return view('livewire.admin.settings.create');
    }

    public function save(): void
    {
        $this->validate();

        Settings::set($this->key, $this->value, $this->type);

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess();
    }

    public function rules(): array
    {
        return [
            'key' => [
                'required',
                Rule::unique('settings', 'key'),
            ],
            'type'  => ['required'],
            'value' => 'nullable',
        ];
    }
}
