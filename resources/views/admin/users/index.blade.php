<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Usuarios',
        ]
    ]">

    @livewire('admin.users.user-table')

</x-admin-layout>