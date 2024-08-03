<?php

declare(strict_types=1);

namespace App\Livewire\Signatures;

use Livewire\Component;

class Filter extends Component
{
    public bool $modal = false;
    
    public function render()
    {
        return view('livewire.signatures.filter');
    }
}
