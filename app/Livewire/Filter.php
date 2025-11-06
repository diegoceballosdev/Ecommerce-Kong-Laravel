<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Filter extends Component
{
    use WithPagination;

    public $family_id;
    public $category_id;
    public $subcategory_id;
    public $options;
    public $search;

    public $selected_features = [];

    public $orderBy = 1;


    public function mount()
    {
        /*   - $options se obtiene usando el modelo Option y un filtro complejo con whereHas.
        - whereHas('products.subcategory.category', ...) filtra las opciones que tienen productos cuya subcategoría pertenece a una categoría cuya family_id coincide con la familia recibida como parámetro.
        - Además, se usa with(['features' => ...]) para cargar las relaciones features de cada opción, pero solo aquellas que, a través de sus variantes y productos, también pertenecen a la misma familia.
        - Finalmente, se ejecuta get() para obtener la colección de opciones filtradas y cargadas con sus features correspondientes. 
        
        - ES SIMILAR CON CATEGORIAS Y SUBCATEGORIAS, todo en una consulta compleja*/

        $this->options = Option::when($this->family_id, function ($query) {
            $query->whereHas('products.subcategory.category', function ($query) {
                $query->where('family_id', $this->family_id);
            })
                ->with([

                    'features' => function ($query) {
                        $query->whereHas('variants.product.subcategory.category', function ($query) {
                            $query->where('family_id', $this->family_id);
                        });
                    },
                ]);
        })
        
        ->when($this->category_id, function ($query) {
            $query->whereHas('products.subcategory', function ($query) {
                $query->where('category_id', $this->category_id);
            })
                ->with([

                    'features' => function ($query) {
                        $query->whereHas('variants.product.subcategory', function ($query) {
                            $query->where('category_id', $this->category_id);
                        });
                    },
                ]);
        })

        ->when($this->subcategory_id, function ($query) {
            $query->whereHas('products', function ($query) {
                $query->where('subcategory_id', $this->subcategory_id);
            })
                ->with([

                    'features' => function ($query) {
                        $query->whereHas('variants.product', function ($query) {
                            $query->where('subcategory_id', $this->subcategory_id);
                        });
                    },
                ]);
        })
        
        ->get()->toArray(); //->toArray() para convertir la colección de Eloquent en un array simple, lo que facilita su manipulación y uso en la vista.

    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {

        //inicialmente verificamos si hay algo en el campo family_id
        $products = Product::when($this->family_id, function ($query) {
            $query->whereHas('subcategory.category', function ($query) {
                $query->where('family_id', $this->family_id);
            });
        })

        //verificamos si hay algo en el campo category_id
        ->when($this->category_id, function ($query) {
            $query->whereHas('subcategory', function ($query) {
                $query->where('category_id', $this->category_id);
            });
        })

        //verificamos si hay algo en el campo subcategory_id
        ->when($this->subcategory_id, function ($query) {
            $query->where('subcategory_id', $this->subcategory_id);
        })

            // Condiciones de orden en caso de seleccionar alguna opción de orden
            ->when($this->orderBy == 1, function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->when($this->orderBy == 2, function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($this->orderBy == 3, function ($query) {
                $query->orderBy('price', 'asc');
            })

            // Condición de filtros por características en caso de seleccionar alguna característica
            ->when($this->selected_features, function ($query) {
                $query->whereHas('variants.features', function ($query) {
                    $query->whereIn('features.id', $this->selected_features);
                    //filtrar los productos que tienen alguna de las características seleccionadas (no necesariamente cumple en simultaneo con todos los filtros, es decir, un producto puede tener una característica o otra de las seleccionadas)
                });
            })

            // Condición de búsqueda en caso de escribir en el buscador
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })

            ->paginate(12);

        return view('livewire.filter', compact('products'));
    }
}
