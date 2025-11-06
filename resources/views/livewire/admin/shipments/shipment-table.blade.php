<div>
    {{-- buscador --}}
    <div class="flex items-center space-x-2">
        <input wire:model.live="search" id="search" type="text" placeholder="Buscar por ID, N° Orden, Conductor o Placa"
            class="px-4 py-2 border border-gray-400 rounded-lg mb-4 w-full" />
    </div>

    {{-- tabla --}}
    @if ($shipments->count())
        {{-- TABLE--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                {{-- Encabezado de la tabla (azul vibrante) --}}
                <thead class="text-xs text-white uppercase bg-gradient-to-tl from-blue-900 to-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('id')" class="uppercase ">
                                    ID Envío
                                </button>
                                <x-sort-icon field='id' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('order_id')" class="uppercase ">
                                    N° Orden
                                </button>
                                <x-sort-icon field='order_id' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Conductor
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Placa
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('status')" class="uppercase ">
                                    Estado
                                </button>
                                <x-sort-icon field='status' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($shipments as $shipment)
                        {{-- Fila del envío (efecto cebra con hover) --}}
                        <tr
                            class="odd:bg-white even:bg-blue-50 odd:dark:bg-gray-800 even:dark:bg-blue-950/20 border-b hover:bg-blue-100 transition duration-150 ease-in-out">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$shipment->id}}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{$shipment->order_id}}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{$shipment->driver->user->name}} {{$shipment->driver->user->last_name}}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{$shipment->driver->plate_number}}
                            </td>
                            {{-- Estado - Aplicando colores semánticos (azul, verde, rojo) --}}
                            <td class="px-6 py-4 font-semibold">
                                @php
                                    $statusColor = match ($shipment->status->name) {
                                        'Shipped' => 'text-blue-600',
                                        'Completed' => 'text-green-600',
                                        'Failed' => 'text-red-600',
                                        default => 'text-gray-600',
                                    };
                                @endphp
                                <span class="{{ $statusColor }}">
                                    {{$shipment->status->name}}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-2">
                                    @if ($shipment->status->name == 'Pending')
                                        {{-- Si el estado es Pending, mostrar ambos botones --}}

                                        {{-- Botón de acción principal en azul --}}
                                        <button
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left"
                                            wire:click="markAsCompleted({{ $shipment->id }})">
                                            Marcar como entregado
                                        </button>

                                        {{-- Botón de acción secundaria/peligrosa en rojo --}}
                                        <button
                                            class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:underline text-left"
                                            wire:click="markAsFailed({{ $shipment->id }})">
                                            Marcar como error de entrega
                                        </button>
                                    @endif
                                    {{-- Si el estado es Completed o Failed, no hay acciones visibles en este bloque --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{-- PAGINATE--}}
        <div class="mt-4">
            {{$shipments->links()}}
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
                <span class="font-medium">¡Alerta!</span> Todavia no hay envíos registrados.
            </div>
        </div>

    @endif

</div>