<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use App\Models\Product;
use App\Models\Variant;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ProductVariants extends Component
{
    public $product; //se recibe desde el componente de livewire que nos redirigio hasta aqui

    public $openModal = false;

    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ],
        ]
    ];

    public $variantEdit = [
        'open' => false,
        'id' => null,
        'stock' => null,
        'sku' => null,
    ];

    public $new_feature = [
        //'option_id' => 'feature_id',    esta es la estructura del array
    ];

    #[Computed()]
    public function options()
    {
        return Option::whereDoesntHave('products', function ($query) {
            $query->where('product_id', $this->product->id);
        })->get();
    }

    public function editVariant(Variant $variant)
    {

        $this->variantEdit = [
            'open' => true,
            'id' => $variant->id,
            'stock' => $variant->stock,
            'sku' => $variant->sku,
        ];
    }

    public function updateVariant()
    {
        $this->validate([
            'variantEdit.stock' => 'required|numeric',
            'variantEdit.sku' => 'required',
        ]);

        $variant = Variant::find($this->variantEdit['id']);

        $variant->update([
            'stock' => $this->variantEdit['stock'],
            'sku' => $this->variantEdit['sku'],
        ]);

        $this->reset('variantEdit');

        $this->product = $this->product->fresh();
    }

    public function updatedVariantOptionId()
    {
        $this->variant['features'] = [
            [
                'id' => '',
                'value' => '',
                'description' => '',
            ],
        ];
    }

    #[Computed()]
    public function features()
    {
        return Feature::where('option_id', $this->variant['option_id'])->get();
    }

    public function getFeatures($option_id)
    {

        $features = DB::table('option_product')
            ->where('product_id', $this->product->id)
            ->where('option_id', $option_id)
            ->first()
            ->features;

        $features = collect(json_decode($features))->pluck('id');

        return Feature::where('option_id', $option_id)
            ->whereNotIn('id', $features)
            ->get();
    }

    public function addFeature()
    {
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => '',
        ];
    }

    public function addNewFeature($option_id)
    {
        $this->validate([
            'new_feature.' . $option_id => 'required|exists:features,id',
        ], );

        $feature = Feature::find($this->new_feature[$option_id]);

        $this->product->options()->updateExistingPivot(
            $option_id,
            [
                'features' => array_merge($this->product->options->find($option_id)->pivot->features, [
                    [
                        'id' => $feature->id,
                        'value' => $feature->value,
                        'description' => $feature->description,
                    ]
                ])
            ],
        );

        $this->product = $this->product->fresh();

        $this->new_feature[$option_id] = '';

        $this->generarVariantes();

    }

    public function feature_change($index)
    {
        $feature = Feature::find($this->variant['features'][$index]['id']);

        if ($feature) {
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }

    public function removeFeature($index)
    {
        unset($this->variant['features'][$index]); //eliminar el feature de ese indice $index, pero deja huecos en los indices, por ejemplo indices 0,1,3 (eliminamos el 2)

        $this->variant['features'] = array_values($this->variant['features']); //reestablece el orden de los indices, es decir indices 0,1,2,3 ...
    }

    public function deleteFeature($option_id, $feature_id)
    {
        //eliminamos el feature del array de features de la opcion en la tabla intermedia option_product
        $this->product->options()->updateExistingPivot(
            $option_id,
            [
                'features' => array_filter($this->product->options->find($option_id)->pivot->features, function ($feature) use ($feature_id) {
                    return $feature['id'] != $feature_id;
                })
            ],
        );

        //eliminamos las variantes que tengan ese feature
        Variant::where('product_id', $this->product->id)
            ->whereHas('features', function ($query) use ($feature_id) {
                $query->where('features.id', $feature_id);
            })->delete();

        //recargamos las opciones del producto para evitar el error al comprobar si tiene features
        $this->product->load('options'); //implementado por mi, a la solucion original

        // comprobamos si la opcion tiene features
        if (empty($this->product->options->find($option_id)->pivot->features)) {
            $this->deleteOption($option_id); //si no quedan features, eliminamos la opcion
        }

        $this->product = $this->product->fresh();
        //$this->generarVariantes();
    }

    public function deleteOption($option_id)
    {
        $this->product->options()->detach($option_id); //detach() eliminar el registro de la TABLA INTERMEDIA
        $this->product = $this->product->fresh();

        $this->product->variants()->delete(); //eliminamos las variantes anteriores

        $this->generarVariantes();
    }

    public function generarVariantes()
    {
        $features = $this->product->options->pluck('pivot.features');

        $combinaciones = $this->generarCombinaciones($features); //generamos las combinaciones

        foreach ($combinaciones as $combinacion) {

            $variant = Variant::where('product_id', $this->product->id)
                ->has('features', count($combinacion))
                ->whereHas('features', function ($query) use ($combinacion) {
                    $query->whereIn('features.id', $combinacion);
                })
                ->whereDoesntHave('features', function ($query) use ($combinacion) {
                    $query->whereNotIn('features.id', $combinacion);
                })
                ->first();

            if ($variant) {
                continue; //si la variante ya existe, saltamos a la siguiente combinacion
            }

            //por cada combinacion creamos una variante nueva
            $variant = Variant::create([
                'product_id' => $this->product->id,
            ]);

            $variant->features()->attach($combinacion); //relacionamos la variante con sus features
        }

        $this->dispatch('variant-generate'); //disparamos el evento para que el componente ProductEdit actualice su producto

    }

    public function generarCombinaciones($arrays, $indice = 0, $combinacion = [])
    {

        if ($indice == count($arrays)) {
            return [$combinacion]; //caso base: si hemos recorrido todos los arrays, devolvemos la combinacion actual
        }

        $resultado = []; //array donde guardaremos las combinaciones

        foreach ($arrays[$indice] as $item) {

            $combinacionTemporal = $combinacion; //copiamos la combinacion actual ['1','2']
            $combinacionTemporal[] = $item['id']; //agregamos el nuevo elemento a la combinacion temporal ['1,'2','3']

            $resultado = array_merge($resultado, $this->generarCombinaciones($arrays, $indice + 1, $combinacionTemporal)); //llamada recursiva

        }

        return $resultado;
    }

    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }

    public function save()
    {
        $this->validate([
            'variant.option_id' => 'required',
            'variant.features.*.id' => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        $features = collect($this->variant['features']);
        $features = $features->unique('id')->values()->all(); //eliminamos duplicados

        $this->product->options()->attach( //el metodo attach() se encarga de agregar registros en la tabla intermedia
            $this->variant['option_id'],
            [
                'features' => $features
            ] //en teoria aqui debi usar json_encode() pero no hace falta gracias al casteo definido en el modelo OptionProduct
        );

        //$this->product = $this->product->fresh();

        $this->product->variants()->delete(); //eliminamos las variantes anteriores

        $this->generarVariantes();

        $this->reset(['variant', 'openModal']);

    }

}
