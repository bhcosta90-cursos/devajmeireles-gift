<?php

declare(strict_types = 1);

namespace App\Livewire\Signatures;

use App\Enums\DeliveryType;
use App\Livewire\Traits\Dialog;
use App\Models\{Item, Signature};
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Manage extends Component
{
    use Dialog;

    public bool $slide = false;

    public string $title = 'Create Signature';

    public ?Signature $signature = null;

    public ?string $name = null;

    public ?Item $modelItem = null;

    public ?int $item = null;

    public int $quantity = 1;

    public ?string $phone = null;

    public ?string $observation = null;

    public ?int $delivery = null;

    public function render(): View
    {
        return view('livewire.signatures.manage');
    }

    public function updatedItem(): void
    {
        $this->modelItem = Item::find($this->item);
    }

    public function save(): Signature | bool
    {
        $data = $this->validate() + [
            'item_id'  => $this->item,
            'delivery' => $this->delivery,
        ];

        $response = $this->signature
            ? $this->signature->update($data)
            : Signature::create($data);

        $this->reset();
        $this->dispatch('manage::list');

        $this->notifySuccess();

        return $response;
    }

    #[Computed]
    public function getDelivery(): array
    {
        return DeliveryType::toSelect();
    }

    protected function rules(): array
    {
        return [
            'name'        => 'required|min:2',
            'item'        => ['required', Rule::exists('items', 'id')],
            'quantity'    => 'required|numeric|min:1',
            'phone'       => 'required',
            'observation' => 'nullable',
            'delivery'    => ['required', Rule::enum(DeliveryType::class)],
        ];
    }
}
