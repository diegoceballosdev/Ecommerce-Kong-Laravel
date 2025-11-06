<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    //use Livewire\WithFileUploads;
    use WithFileUploads; //Necesario para subir img en livewire

    public $product;
    public $productEdit;

    public $families;
    public $family_id = '';
    public $category_id = '';
    public $image;

    public function mount($product)
    {
        //Solo tomare los valores de campos que me interesan:
        $this->productEdit = $product->only('sku', 'name', 'description', 'price', 'image_path', 'subcategory_id');

        $this->families = Family::all();
        $this->family_id = $product->subcategory->category->family_id;
        $this->category_id = $product->subcategory->category_id;
    }

    public function boot()
    {
        $this->withValidator(function ($validator) {

            if ($validator->fails()) {
                $this->dispatch('swal', [
                    'icon' => "error",
                    'title' => "¡Error!",
                    'text' => 'El formulario no se llenó correctamente.'
                ]);
            }
        });
    }

    #[Computed()] //Importar 'propiedades computadas'
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()] //Importar 'propiedades computadas'
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function updatedFamilyId()
    {
        $this->category_id = '';
        $this->productEdit['subcategory_id'] = '';
    }

    public function updatedCategoryId()
    {
        $this->productEdit['subcategory_id'] = '';
    }

    #[On('variant-generate')] 
    //escuchamos el evento disparado desde ProductVariants en el metodo 'generarVariantes()'
    public function updateProduct(){
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }

    public function store()
    {
        $this->validate([
            'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id, //exluimos el propio producto para que la validacion no considere el 'unique' e impida actualizar.
            'productEdit.name' => 'required|max:255',
            'productEdit.description' => 'required',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
            'image' => 'nullable|image|max:1024', //nullable porque no necesariamente se deseara cambiar la img
        ], [], [
            'productEdit.sku' => 'codigo sku',
            'productEdit.name' => 'nombre',
            'productEdit.description' => 'descripción',
            'productEdit.price' => 'precio',
            'productEdit.subcategory_id' => 'subcategoria',
            'image' => 'imagen',
        ]);

        if ($this->image) {
            //use Illuminate\Support\Facades\Storage;
            Storage::delete($this->productEdit['image_path']);

            $this->productEdit['image_path'] = $this->image->store('products'); //guardamos la imagen en el image_path producto
        }

        $this->product->update($this->productEdit); //se actualizan los campos por estar enlazados con sus respectivas llaves

        session()->flash('swal', [
            'icon' => "success",
            'title' => "Listo",
            'text' => 'Se ha editado el producto correctamente.'
        ]);

        //Usamos esto si no se redirecciona a ningun lado, sino no veremos la alerta:
        // $this->dispatch('swal',[
        //     'icon' => "success",
        //     'title' => "Listo",
        //     'text' => 'Se ha actualizado la subcategoria correctamente.'
        // ]);


        return redirect()->route('admin.products.edit', $this->product);
    }
}
