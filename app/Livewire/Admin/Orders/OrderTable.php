<?php

namespace App\Livewire\Admin\Orders;

use App\Enums\OrderStatus;
use App\Enums\ShipmentStatus;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public $drivers;

    public $new_shipment = [
        'openModal' => false,
        'order_id' => '',
        'driver_id' => '',
    ];

    public $detailsModalOpen = false;

    public $selectedOrder;

    public function mount()
    {
        // Inicialización si es necesario
        $this->drivers = Driver::all();
    }

    public function render()
    {
        $orders = Order::Where('id', 'like', '%' . $this->search . '%')
            ->orWhere('created_at', 'like', '%' . $this->search . '%')
            ->orWhere('total', 'like', '%' . $this->search . '%')
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.orders.order-table', compact('orders'));
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

    public function downloadInvoice(Order $order)
    {
        return Storage::download($order->pdf_path);
    }

    public function markAsProcessing(Order $order)
    {
        $order->status = OrderStatus::Processing;
        $order->save();
    }

    public function assignDriver(Order $order)
    {
        // Lógica para asignar el repartidor a la orden
        $this->new_shipment['order_id'] = $order->id;
        $this->new_shipment['openModal'] = true;
    }

    public function saveShipment()
    {
        $this->validate([
            'new_shipment.driver_id' => 'required|exists:drivers,id',
        ]);

        $order = Order::find($this->new_shipment['order_id']);
        $order->status = OrderStatus::Shipped; // O el estado que corresponda
        $order->save();

        $order->shipments()->create([
            'driver_id' => $this->new_shipment['driver_id'],
        ]);

        // Cerrar el modal y resetear los campos
        $this->reset('new_shipment');

        $this->dispatch('swal', [
            'title' => 'Repartidor asignado correctamente.',
            'icon' => 'success',
        ]);
    }

    public function markAsRefunded(Order $order)
    {
        $order->status = OrderStatus::Refunded;
        $order->save();

        $shipment = $order->shipments->last();
        $shipment->refunded_at = now();
        $shipment->save();
    }

    public function cancelOrder(Order $order)
    {

        if ($order->status == OrderStatus::Shipped) {
            $this->dispatch('swal', [
                'title' => 'No se puede cancelar la orden.',
                'icon' => 'error',
                'text' => 'La orden tiene envíos pendientes.',
            ]);

            return;
        }

        if ($order->status == OrderStatus::Failed) {
            $this->dispatch('swal', [
                'title' => 'No se puede cancelar la orden.',
                'icon' => 'error',
                'text' => 'El pedido aún no ha sido regresado.',
            ]);

            return;
        }


        $order->status = OrderStatus::Cancelled;
        $order->save();
    }

    public function showOrderDetails(Order $order)
    {
        $this->selectedOrder = $order;
        $this->detailsModalOpen = true;
    }
}