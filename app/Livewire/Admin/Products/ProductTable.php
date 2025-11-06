<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function render()
    {
        $products = Product::with('subcategory.category.family') //precargamos la relaciones para evitar consultas adicionales
            ->where(function ($query) {
                $query->Where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('price', 'like', '%' . $this->search . '%')
                    ->orWhereHas('subcategory', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('subcategory.category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('subcategory.category.family', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.products.product-table', compact('products'));
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
