<?php

namespace App\Livewire\Forms;

use App\Enums\TypeOfDocument;
use App\Models\Address;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateAddressForm extends Form
{
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

    public function save()
    {
        $this->validate();

        // Si es la primera dirección del usuario, establecer como predeterminada
        if (auth()->user()->addresses()->count() === 0) {
            $this->default = true;
        }

        // Lógica para guardar la dirección en la base de datos

        Address::create([
            'user_id' => auth()->id(),
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

        // Resetear el formulario después de guardar
        $this->reset();

        $this->receiver_info = [
            'name' => auth()->user()->name,
            'last_name' => auth()->user()->last_name,
            'document_type' => auth()->user()->document_type,
            'document_number' => auth()->user()->document_number,
            'phone' => auth()->user()->phone,
        ];
    }
}
