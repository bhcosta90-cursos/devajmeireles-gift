<?php

declare(strict_types = 1);

namespace App\Livewire\Traits;

use TallStackUi\Traits\Interactions;

trait Dialog
{
    use Interactions;

    protected function deleteItem($params, $action = 'canDelete'): void
    {
        $this->dialog()
            ->question(__('Warning!'), __('Are you sure?'))
            ->confirm(__('Confirm'), $action, $params)
            ->cancel(__('Cancel'))
            ->send();
    }

    protected function notify($message = 'Register deleted successfully'): void
    {
        $this->toast()->success(__($message))->send();
    }
}
