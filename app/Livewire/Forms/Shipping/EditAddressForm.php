<?php

namespace App\Livewire\Forms\Shipping;

use App\Enums\TypeOfDocument;
use App\Models\Address;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EditAddressForm extends Form
{
    public $id;
    public $type = '';
    public $description = '';
    public $reference = '';
    public $postal_code = '';
    public $locality = '';
    public $province = '';
    public $receiver = 1;
    public $receiver_info = [];
    public $default = false;

public function rules(): array
    {
        return [
            'type' => 'required|in:1,2',
            'description' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'postal_code' => 'required|string|max:9',
            'locality' => 'required|string|max:40',
            'province' => 'required|string|max:20',
            'receiver' => 'required|in:1,2',
            'receiver_info' => 'required|array',
            'receiver_info.name' => 'required|string|max:50',
            'receiver_info.last_name' => 'required|string|max:50',
            'receiver_info.document_type' => [
                'required',
                new Enum(TypeOfDocument::class),
            ],
            'receiver_info.document_number' => 'required|string|max:20',
            'receiver_info.phone' => 'required|string|max:15',
        ];
    }

    public function validationAttributes()
    {
        return [
            'type' => 'tipo de dirección',
            'description' => 'descripción',
            'reference' => 'referencia',
            'postal_code' => 'código postal',
            'locality' => 'localidad',
            'province' => 'provincia',
            'receiver' => 'destinatario',
            'receiver_info.name' => 'nombre del destinatario',
            'receiver_info.last_name' => 'apellido del destinatario',
            'receiver_info.document_type' => 'tipo de documento del destinatario',
            'receiver_info.document_number' => 'número de documento del destinatario',
            'receiver_info.phone' => 'teléfono del destinatario',
        ];
    }

    public function edit($address)
    {
        $this->id = $address->id;
        $this->type = $address->type;
        $this->description = $address->description;
        $this->reference = $address->reference;
        $this->postal_code = $address->postal_code;
        $this->locality = $address->locality;
        $this->province = $address->province;
        $this->receiver = $address->receiver;
        $this->receiver_info = $address->receiver_info;
        $this->default = $address->default;

    }

    public function update()
    {
        $this->validate();

        $address = Address::find($this->id);

        $address->update([
            'type' => $this->type,
            'description' => $this->description,
            'reference' => $this->reference,
            'postal_code' => $this->postal_code,
            'locality' => $this->locality,
            'province' => $this->province,
            'receiver' => $this->receiver,
            'receiver_info' => $this->receiver_info,
            'default' => $this->default,
        ]);

        // Resetea todos los campos del formulario incluyendo el id, por ende el formulario se oculta
        $this->reset();
    }
    
}
