<?php

namespace App\Livewire\Admin\Drivers;

use App\Models\Driver;
use Livewire\Component;
use Livewire\WithPagination;

class DriverTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;


    public function render()
    {
        $drivers = Driver::with('user') //precargamos la relaciones para evitar consultas adicionales
            ->where(function ($query) {
                $query->Where('id', 'like', '%' . $this->search . '%')
                    ->orWhere('plate_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('last_name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.drivers.driver-table', compact('drivers'));
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
