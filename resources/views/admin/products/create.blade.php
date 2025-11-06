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
            'name' => 'Nuevo',
        ],
    ]">
    <div class="card">
    
        @livewire('admin.products.product-create')

    </div>

</x-admin-layout>