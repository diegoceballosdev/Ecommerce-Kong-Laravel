<?php

namespace App\Livewire\Forms\Admin\Options;

use App\Models\Option;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewOptionForm extends Form
{
    public $openModal = false; //lo cambiaremos con metodo magico $set
    public $name;
    public $type = 1;
    public $features = [
        [
            'value' => '',
            'description' => '',
        ],
    ];

    public function rules()
    {
        $rules = ([
            'name' => 'required',
            'type' => 'required|in:1,2', //solo dos posibles valores:1,2
            'features' => 'required|array|min:1', //tipo aray con al menos 1 elemento
        ]);

        foreach ($this->features as $index => $feature) { //de aqui nos importa el index

            if ($this->type == 1) {
                $rules['features.' . $index . '.value'] = 'required'; //decimos que value es requerido
            } else {
                $rules['features.' . $index . '.value'] = 'required|regex:/^#[a-f0-9]{6}$/i'; //decimos que value es requerido y usa una expresion regular para verificar que sea un color
            }

            $rules['features.' . $index . '.description'] = 'required|max:255'; //decimos que description es requerido
        }

        return $rules;
    }

    public function validationAttributes()
    {
        $attributes = [
            'name' => 'nombre',
            'type' => 'tipo',
            'features' => 'valores',
        ];

        foreach ($this->features as $index => $feature) {
            $attributes[ 'features.'.$index.'.value'] = 'valor '.($index + 1);
            $attributes[ 'features.'.$index.'.description'] = 'descripcion '.($index + 1);
        }

        return $attributes;
    }

    public function addFeature()
    {
        $this->features[] = [
            'value' => '',
            'description' => '',
        ];
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]); //eliminar el feature de ese indice $index, pero deja huecos en los indices, por ejemplo indices 0,1,3 (eliminamos el 2)

        $this->features = array_values($this->features); //reestablece el orden de los indices, es decir indices 0,1,2,3 ...
    }

    public function save()
    {
        $this->validate();

        $option = Option::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        foreach ($this->features as $feature) {

            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
            ]);
        }
        $this->reset();
    }
}