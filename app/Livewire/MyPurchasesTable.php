<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class MyPurchasesTable extends Component
{
    public $detailsModalOpen = false;

    public $selectedOrder;

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('livewire.my-purchases-table', compact('orders'));
    }

    public function downloadInvoice(Order $order)
    {
        return Storage::download($order->pdf_path);
    }

    public function showOrderDetails(Order $order)
    {
        $this->selectedOrder = $order;
        $this->detailsModalOpen = true;
    }
}
