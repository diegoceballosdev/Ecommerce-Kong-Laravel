<?php

namespace App\Livewire\Admin\Shipments;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use App\Models\Shipment;
use Livewire\Component;
use Livewire\WithPagination;

class ShipmentTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function mount()
    {
        // Inicialización si es necesario

    }

    public function render()
    {
        $shipments = Shipment::with('driver.user') //precargamos la relaciones para evitar consultas adicionales
            ->where(function ($query) {
                $query->Where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('order_id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('driver', function ($q) {
                        $q->where('plate_number', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('driver.user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    })
                ;
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.shipments.shipment-table', compact('shipments'));
    }

    public function markAsCompleted(Shipment $shipment)
    {
        $shipment->status = ShipmentStatus::Completed;
        $shipment->delivered_at = now();
        $shipment->save();

        $order = $shipment->order;
        $order->status = OrderStatus::Completed;
        $order->save();
    }

    public function markAsFailed(Shipment $shipment)
    {
        $shipment->status = ShipmentStatus::Failed;
        $shipment->save();

        $order = $shipment->order;
        $order->status = OrderStatus::Failed;
        $order->save();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
}