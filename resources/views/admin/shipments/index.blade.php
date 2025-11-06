<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Envíos',
        ]
    ]">


    <x-slot name='action'>
        {{-- Botón con estilo azul consistente --}}
        <a class="btn btn-blue"
            href="#">
            Botón
        </a>
    </x-slot>

    @livewire('admin.shipments.shipment-table')

</x-admin-layout>