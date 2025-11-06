<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Productos',
        ]
    ]">

    <x-slot name='action'>
        <a class="btn btn-blue" href="{{route('admin.products.create')}}">
            Agregar Nuevo
        </a>
    </x-slot>

    @livewire('admin.products.product-table')

</x-admin-layout>