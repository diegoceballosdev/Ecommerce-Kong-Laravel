<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = '';
    public $sortAsc = true;

    public function render()
    {
        $users = User::with(['roles', 'permissions'])
            ->where(function ($query) {
                $query->Where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('document_number', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('roles', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                ;
            })
            ->when($this->sortField, function ($query) {
                $query->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            })
            ->paginate(10);

        return view('livewire.admin.users.user-table', compact('users'));
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

    public function assignRole(int $userId, string $value): void
    {
        $user = User::findOrFail($userId);

        // Reemplaza el rol actual por el nuevo (evita roles acumulados)
        $user->syncRoles([$value]);

        $this->dispatch(
            'swal',
            [
                'icon' => 'success',
                'title' => 'Rol asignado',
                'text' => "El rol de $user->name $user->last_name ha sido modificado correctamente.",
            ]
        );
    }
}
