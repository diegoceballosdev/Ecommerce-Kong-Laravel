<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageOptions extends Component
{
    public $options;

    public NewOptionForm $newOption; //usa un FORM OBJECT

    public function mount()
    {
        $this->options = Option::with('features')->get();
    }

    #[On('featureAdded')]
    public function updateOptionList()
    {
        $this->options = Option::with('features')->get(); //recarganmos para que aparezcan los nuevos features que hemos creado 
    }

    public function addFeature()
    {
        $this->newOption->addFeature();
    }

    public function removeFeature($index)
    {
        $this->newOption->removeFeature($index);
    }

    public function deleteFeature(Feature $feature)
    {
        $feature->delete();
        $this->options = Option::with('features')->get();
    }
    
    public function deleteOption(Option $option)
    {
        $option->delete();
        $this->options = Option::with('features')->get();
    }

    public function addOption()
    {
        $this->newOption->save();

        $this->options = Option::with('features')->get(); //recarganmos para que aparezcan los que hemos creado 

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho',
            'text' => 'La opción se agregó con exito',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
