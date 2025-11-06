<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Categorias',
        ]
    ]">

    <x-slot name='action'>
        <a class="btn btn-blue" href="{{route('admin.categories.create')}}">
            Agregar Nuevo
        </a>
    </x-slot>

    @livewire('admin.categories.category-table')
    
</x-admin-layout>