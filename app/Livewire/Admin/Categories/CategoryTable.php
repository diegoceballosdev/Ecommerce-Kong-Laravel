<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function render()
    {
        $categories = Category::with('family') //precargamos la relacion para evitar consultas adicionales
            ->where(function ($query) {
                $query->Where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('family', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.categories.category-table', compact('categories'));
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
