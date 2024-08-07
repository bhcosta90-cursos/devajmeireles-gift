<?php

declare(strict_types = 1);

namespace App\Livewire\Signatures;

use App\Enums\DeliveryType;
use App\Livewire\Traits\Dialog;
use App\Models\{Item, Signature};
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\{Rule, ValidationException};
use Livewire\Attributes\{Computed, On};
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

    public function createItem(): void
    {
        $this->reset();
        $this->slide = true;
    }

    #[On('manager::edit')]
    public function load(Signature $signature): void
    {
        $this->signature = $signature;

        $this->modelItem   = $signature->item;
        $this->name        = $signature->name;
        $this->item        = $signature->item_id;
        $this->phone       = $signature->phone;
        $this->observation = $signature->observation;
        $this->delivery    = $signature->delivery->value;

        $this->title = 'Edit Signature';
        $this->slide = true;

    }

    public function save(): array | bool
    {
        $data = $this->validate() + [
            'item_id'  => $this->item,
            'delivery' => $this->delivery,
        ];

        $response = $this->signature
            ? $this->updateSignature($data)
            : $this->createSignature($data);

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

    protected function createSignature(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $response = $this->modelItem->signatures()
                ->createMany(Collection::times($data['quantity'], fn () => $data))
                ->toArray();

            $this->modelItem->update(['last_signed_at' => now()]);

            return $response;
        });
    }

    protected function updateSignature(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            if (($current = $this->signature->item)->isNot($this->modelItem)) {
                if (!$this->modelItem->available()) {
                    $this->resetExcept();

                    throw ValidationException::withMessages(['item' => __('Item is not available')]);
                }

                if ($data['quantity'] === 1 || $this->modelItem->signatures()->count() === $data['quantity']) {
                    $this->modelItem->is_active = false;
                }

                $this->modelItem->last_signed_at = now();
                $this->modelItem->save();

                $current->update(['last_signed_at' => null]);
            }

            return $this->signature->update($data);
        });
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
