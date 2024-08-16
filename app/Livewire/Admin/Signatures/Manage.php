<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Signatures;

use App\Enums\DeliveryType;
use App\Livewire\Traits\HasDialog;
use App\Livewire\Traits\Permission\HasPermissionCreate;
use App\Livewire\Traits\Signature\SignatureCreate;
use App\Models\{Item, Signature};
use Arr;
use DB;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\{ValidationException};
use Livewire\Attributes\{Computed, On};
use Livewire\Component;

class Manage extends Component
{
    use HasDialog;
    use HasPermissionCreate;

    use SignatureCreate {
        createSignature as createSignature;
        rulesSignature as rules;
    }

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

    public ?int $presence = null;

    public function mount(): void
    {
        $this->authorize('manage', Signature::class);
    }

    public function render(): View
    {
        return view('livewire.admin.signatures.manage');
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
        $this->authorize('edit', $signature);

        $this->signature = $signature;
        $this->authorize('manage', $signature);

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
        $this->authorize(
            $this->signature ? "edit" : "create",
            $this->signature ?: Signature::class,
        );

        $data = $this->validate() + [
            'item_id'  => $this->item,
            'delivery' => $this->delivery,
        ];

        $response = $this->signature
            ? $this->updateSignature($data)
            : $this->createSignature(
                item: $this->modelItem,
                name: $data['name'],
                phone: $data['phone'],
                delivery: $data['delivery'],
                quantity: $data['quantity'],
                observation: $data['observation'],
                presence: $data['presence'] ?? 0,
            );

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

            return $this->signature->update(Arr::except($data, ['quantity', 'item', 'presence']));
        });
    }

    protected function getCreatePermissionParams(): array
    {
        return [
            Signature::class,
        ];
    }

    protected function messages(): array
    {
        return [
            'presence.required' => __('For the type of delivery as in-person, the number of people at the event field is mandatory to inform at least 0'),
        ];
    }

    protected function item(): ?Item
    {
        return $this->modelItem;
    }
}
