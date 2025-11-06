<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Familias',
        ]
    ]">


    <x-slot name='action'>
        <a class="btn btn-blue" href="{{route('admin.families.create')}}">
            Agregar Nuevo
        </a>
    </x-slot>

    @livewire('admin.families.family-table')

</x-admin-layout>