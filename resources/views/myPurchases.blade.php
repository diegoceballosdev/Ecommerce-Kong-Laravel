<x-app-layout>

    <x-container>

        <div class="py-12 px-4">

            {{-- Título de la página --}}

            <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">Mis Compras</h1>

            @livewire('my-purchases-table')

        </div>

    </x-container>

</x-app-layout>