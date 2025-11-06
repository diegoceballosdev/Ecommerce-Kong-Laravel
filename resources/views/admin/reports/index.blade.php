<x-admin-layout :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'route' => route('admin.dashboard')
        ],
        [
            'name' => 'Reportes',
        ]
    ]">

    @livewire('admin.reports.select-reports')

</x-admin-layout>