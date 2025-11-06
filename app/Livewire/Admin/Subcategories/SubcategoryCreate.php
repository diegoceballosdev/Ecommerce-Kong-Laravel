<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubcategoryCreate extends Component
{

    public $families;
    public $subcategory = [
        'family_id' => '',
        'category_id' => '',
        'name' => '',
    ];

    public function mount()
    {
        $this->families = Family::all();
    }

    # Ciclo de vida del componente: si ocurre cambios en el componente (en este caso en el select, que modifica la llave family_id del array), entonces se resetea la categoria
    public function updatedSubcategoryFamilyId()
    {
        $this->subcategory['category_id'] = '';
    }

    #[Computed()] //Importar 'propiedades computadas'
    public function categories()
    {
        return Category::where('family_id', $this->subcategory['family_id'])->get();
    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-create');
    }

    public function save()
    {
        $this->validate([
            'subcategory.family_id' => 'required|exists:families,id',
            'subcategory.category_id' => 'required|exists:categories,id',
            'subcategory.name' => 'required', 
        ],
        [],
        [
            'subcategory.family_id' => 'familia',
            'subcategory.category_id' => 'categoria',
            'subcategory.name' => 'nombre', 
        ]);

        Subcategory::create($this->subcategory);

        session()->flash('swal', [
            'icon' => "success",
            'title' => "Listo",
            'text' => 'Se ha creado una nueva subcategoria de productos.'
        ]);

        return redirect()->route('admin.subcategories.index');
    }
}
