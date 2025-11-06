<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Subategorias',
        ]
    ]">

<x-slot name='action'>
    <a class="btn btn-blue" href="{{route('admin.subcategories.create')}}">
        Agregar Nuevo
    </a>
</x-slot>

    @livewire('admin.subcategories.subcategory-table')

</x-admin-layout>