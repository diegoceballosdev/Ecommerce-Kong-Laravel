<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads; //Necesario para subir img en livewire

    public $families;
    public $family_id = '';
    public $category_id = '';
    public $image;

    public $product = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'price' => '',
        'subcategory_id' => '',
        'image_path' => '',
    ];

    public function mount()
    {
        $this->families = Family::all();
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
        $this->product['subcategory_id'] = '';
    }

    public function updatedCategoryId()
    {
        $this->product['subcategory_id'] = '';
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }

    public function store()
    {
        $this->validate([
            'product.sku' => 'required|unique:products,sku',
            'product.name' => 'required|max:255',
            'product.description' => 'required',
            'product.price' => 'required|numeric|min:0',
            'product.subcategory_id' => 'required|exists:subcategories,id',
            'image' => 'required|image|max:1024',
        ], [], [
            'product.sku' => 'codigo sku',
            'product.name' => 'nombre',
            'product.description' => 'descripción',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoria',
            'image' => 'imagen',
        ]);

        $this->product['image_path'] = $this->image->store('products'); //guardamos la imagen en el image_path producto

        $product = Product::create($this->product);

        session()->flash('swal', [
            'icon' => "success",
            'title' => "Listo",
            'text' => 'Se ha creado el nuevo producto correctamente.'
        ]);

        return redirect()->route('admin.products.index', $product);
    }
}
