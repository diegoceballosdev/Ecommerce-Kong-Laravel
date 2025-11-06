<div>

    {{-- buscador --}}
    <div>

        <input wire:model.live="search" id="search" type="text"
            placeholder="Buscar por ID o Nombre"
            class="px-4 py-2 border border-gray-400 rounded-lg mb-4 w-full" />
    </div>

    {{-- tabla --}}
    @if ($families->count())
        {{-- TABLE--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                {{-- Encabezado de la tabla (azul vibrante) --}}
                <thead class="text-xs text-white uppercase bg-gradient-to-tl from-blue-900 to-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('id')" class="uppercase ">
                                    ID
                                </button>
                                <x-sort-icon field='id' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('name')" class="uppercase ">
                                    Nombre
                                </button>
                                <x-sort-icon field='name' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($families as $family)
                        {{-- Fila de la familia (efecto cebra con hover) --}}
                        <tr
                            class="odd:bg-white even:bg-blue-50 odd:dark:bg-gray-800 even:dark:bg-blue-950/20 border-b hover:bg-blue-100 transition duration-150 ease-in-out">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$family->id}}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{$family->name}}
                            </td>
                            <td class="px-6 py-4">
                                {{-- Botón de edición (enlaces en azul) --}}
                                <a class="font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline"
                                    href="{{route('admin.families.edit', $family)}}">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{-- PAGINATE--}}
        <div class="mt-4">
            {{$families->links()}}
        </div>

    @else
        {{-- ALERT (azul consistente) --}}
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">¡Alerta!</span> Todavia no hay familias registradas.
            </div>
        </div>

    @endif

</div>