<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Productos',
            'route' => route('admin.products.index')
        ],
        [
            'name' => $product->name,
        ],
    ]">
    <div class="card">
    
        <div class="mb-12">
            {{-- siempre que incluimos mas de un componente es recomendable pasar una llave key --}}
            @livewire('admin.products.product-edit', ['product' => $product], key('product-edit-'.$product->id))
        </div>

        <div>
            @livewire('admin.products.product-variants', ['product' => $product],key('variants-'.$product->id))
        </div>
        
    </div>

</x-admin-layout> 