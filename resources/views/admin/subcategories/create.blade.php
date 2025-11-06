<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Subcategorias',
            'route' => route('admin.subcategories.index')
        ],
        [
            'name' => 'Nuevo',
        ],
    ]">

    <div class="card">

    @livewire('admin.subcategories.subcategory-create')

    </div>

</x-admin-layout>