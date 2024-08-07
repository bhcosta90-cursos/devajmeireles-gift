<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\HasDialog;
use App\Models\Setting;
use App\Services\Facades\Settings;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{
    use HasDialog;

    public Setting $setting;

    public bool $slide = false;

    public ?string $key = null;

    public mixed $value = null;

    public function mount(): void
    {
        $this->authorize('viewAny', Setting::class);
    }

    #[On('manager::edit')]
    public function load(Setting $setting): void
    {
        $this->setting = $setting;

        $this->key   = $setting->key;
        $this->value = $setting->value;

        if ($setting->type === 'boolean') {
            $this->value = (bool) $setting->value;
        }

        $this->slide = true;
    }

    public function render(): View
    {
        return view('livewire.admin.settings.update');
    }

    public function save(): void
    {
        Settings::set($this->setting->key, $this->setting->value, $this->setting->type);

        $this->slide = false;
        $this->dispatch('manage::list');
        $this->notifySuccess();
    }
}
