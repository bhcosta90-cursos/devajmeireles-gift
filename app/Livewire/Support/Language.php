<?php

declare(strict_types = 1);

namespace App\Livewire\Support;

use Cookie;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Language extends Component
{
    public string $url = '';

    public function render(): View
    {
        return view('livewire.support.language');
    }

    public function mount()
    {
        $this->url = url()->full();
    }

    public function language(string $language): void
    {
        $cookie = Cookie::forever('language', $language);
        Cookie::queue($cookie);

        $this->redirect($this->url);
    }
}
