<?php

namespace App\Livewire\Admin\Families;

use App\Models\Family;
use Livewire\Component;
use Livewire\WithPagination;

class FamilyTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function render()
    {
        $families = Family::Where('id', 'like', '%' . $this->search . '%')
            ->orWhere('name', 'like', '%' . $this->search . '%')
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.families.family-table', compact('families'));
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
