<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Ordenes',
        ]
    ]">

    <x-slot name='action'>
        {{-- Botón con estilo azul consistente --}}
        <a class="btn btn-blue"
            href="#">
            Botón
        </a>
    </x-slot>

    @livewire('admin.orders.order-table')

</x-admin-layout>