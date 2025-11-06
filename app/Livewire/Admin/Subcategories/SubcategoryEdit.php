<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SubcategoryEdit extends Component
{
    public $subcategory;
    public $families;
    public $subcategoryEdit;

    public function mount($subcategory)
    {
        $this->families = Family::all();

        $this->subcategoryEdit = [
            'family_id' => $subcategory->category->family_id,
            'category_id' => $subcategory->category_id,
            'name' => $subcategory->name,
        ];
    }

    # Ciclo de vida del componente: si ocurre cambios en el componente (en este caso en el select, que modifica la llave family_id del array), entonces se resetea la categoria
    public function updatedSubcategoryEditFamilyId()
    {
        $this->subcategoryEdit['category_id'] = '';
    }

    #[Computed()] //Importar 'propiedades computadas'
    public function categories()
    {
        return Category::where('family_id', $this->subcategoryEdit['family_id'])->get();
    }

    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }

    public function save()
    {
        $this->validate([
            'subcategoryEdit.family_id' => 'required|exists:families,id',
            'subcategoryEdit.category_id' => 'required|exists:categories,id',
            'subcategoryEdit.name' => 'required', 
        ],
        [],
        [
            'subcategoryEdit.family_id' => 'familia',
            'subcategoryEdit.category_id' => 'categoria',
            'subcategoryEdit.name' => 'nombre', 
        ]);

        $this->subcategory->update($this->subcategoryEdit);

        //Usamos esto si no se redirecciona a otra ruta:
        session()->flash('swal', [
            'icon' => "success",
            'title' => "Listo",
            'text' => 'Se ha actualizado la subcategoria correctamente.'
        ]);

        return redirect()->route('admin.subcategories.index');
    }
}
