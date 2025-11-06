<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateAddressForm;
use App\Livewire\Forms\Shipping\EditAddressForm;
use App\Models\Address;
use Livewire\Component;

class ShippingAddresses extends Component
{
    public $addresses;
    public $newAddress = false;

    public CreateAddressForm $createAddress; //object form para crear una nueva direccion
    public EditAddressForm $editAddress; //object form para editar una direccion existente

    public function mount()
    {
        // Aquí puedes cargar las direcciones de envío desde la base de datos o cualquier otra fuente
        $this->addresses = Address::where('user_id', auth()->id())->get();

        $this->createAddress->receiver_info = [
            'name' => auth()->user()->name,
            'last_name' => auth()->user()->last_name,
            'document_type' => auth()->user()->document_type,
            'document_number' => auth()->user()->document_number,
            'phone' => auth()->user()->phone,
        ];
    }
    public function render()
    {
        return view('livewire.shipping-addresses');
    }

    public function setDefaultAddress($id)
    {
        $this->addresses->each(function ($address) use ($id) {
            $address->update([
                'default' => $address->id == $id,
            ]);
        });
    }

    public function store()
    {
        $this->createAddress->save();

        // Recargar las direcciones después de guardar una nueva
        $this->addresses = Address::where('user_id', auth()->id())->get();
        $this->newAddress = false; // Ocultar el formulario después de guardar

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Dirección guardada con éxito',
            'timer' => 3000,
        ]);

        return redirect()->route('shipping.index');
    }

    public function edit($id)
    {
        $address = Address::find($id);

        $this->editAddress->edit($address);
    }

    public function update()
    {
        $this->editAddress->update();

        // Recargar las direcciones después de actualizar
        $this->addresses = Address::where('user_id', auth()->id())->get();
        $this->editAddress->id = null; // Ocultar el formulario después de actualizar

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Dirección actualizada con éxito',
            'timer' => 3000,
        ]);

        return redirect()->route('shipping.index');
    }

    public function delete($id)
    {
        $address = Address::find($id);

        $address->delete();

        // Recargar las direcciones después de eliminar
        $this->addresses = Address::where('user_id', auth()->id())->get();

        // Si la dirección eliminada era la predeterminada, establecer otra como predeterminada, si es que existe
        if ($this->addresses->where('default', true)->count() == 0 && $this->addresses->count() > 0) {

            $this->addresses->first()->update(['default' => true]);
        }

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Dirección eliminada con éxito',
            'timer' => 3000,
        ]);

        return redirect()->route('shipping.index');

    }
}