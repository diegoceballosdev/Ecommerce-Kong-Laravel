<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Subcategory;
use Livewire\Component;
use Livewire\WithPagination;

class SubcategoryTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function render()
    {
        // $subcategories = Subcategory::with('category.family') //precargamos la relaciones para evitar consultas adicionales
        //     ->paginate(10);

        $subcategories = Subcategory::with('category.family') //precargamos la relaciones para evitar consultas adicionales
            ->where(function ($query) {
                $query->Where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('category.family', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.subcategories.subcategory-table', compact('subcategories'));
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
