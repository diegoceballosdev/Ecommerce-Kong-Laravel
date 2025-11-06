<div>
    {{-- buscador --}}
    <div class="flex items-center space-x-2">
        <input wire:model.live="search" id="search" type="text"
            placeholder="Buscar por ID, Total, o Fecha (aaaa-mm-dd)"
            class="px-4 py-2 border border-gray-400 rounded-lg mb-4 w-full" />
    </div>

    {{-- tabla --}}
    @if ($orders->count())
        {{-- TABLE--}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                {{-- Encabezado de la tabla (azul vibrante) --}}
                <thead class="text-xs text-white uppercase bg-gradient-to-tl from-blue-900 to-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('id')" class="uppercase ">
                                    N° Orden
                                </button>
                                <x-sort-icon field='id' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Factura
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('created_at')" class="uppercase ">
                                    Fecha
                                </button>
                                <x-sort-icon field='created_at' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center space-x-2">
                                <button wire:click="sortBy('total')" class="uppercase ">
                                    Total
                                </button>
                                <x-sort-icon field='total' :sortField="$sortField" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Detalles
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

                    @foreach ($orders as $order)
                        {{-- Fila de la orden (efecto cebra con hover) --}}
                        <tr class="odd:bg-white even:bg-blue-50 odd:dark:bg-gray-800 even:dark:bg-blue-950/20 border-b hover:bg-blue-100 transition duration-150 ease-in-out">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$order->id}}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{-- Icono de PDF - se mantiene el estilo del botón, aunque la imagen no tiene clases Tailwind aquí --}}
                                <button wire:click="downloadInvoice({{ $order->id }})">
                                    <img src="/img/icons/pdf-icon2.svg" alt="" class="w-10 h-10">
                                </button>
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($order['created_at'])->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800 dark:text-gray-300">
                                ${{$order->total}}
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left"
                                    wire:click="showOrderDetails({{ $order->id }})">
                                    Ver detalles
                                </button>
                            </td>
                            {{-- Estado - Aplicando colores semánticos (por ejemplo, verde para Shipped, rojo para Cancelled/Failed) --}}
                            <td class="px-6 py-4 font-semibold">
                                @php
                                    $statusColor = match($order->status->name) {
                                        'Pending' => 'text-yellow-600',
                                        'Processing' => 'text-indigo-600',
                                        'Shipped' => 'text-green-600',
                                        'Completed' => 'text-emerald-600',
                                        'Failed', 'Cancelled', 'Refunded' => 'text-red-600',
                                        default => 'text-gray-600',
                                    };
                                @endphp
                                <span class="{{ $statusColor }}">
                                    {{$order->status->name}}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-2">
                                    @switch($order->status->name)
                                        @case('Pending')
                                            {{-- Enlaces/Botones de acción en azul --}}
                                            <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left" 
                                            wire:click="markAsProcessing({{ $order->id }})">
                                                Listo para despachar
                                            </button>
                                            @break
                                        @case('Processing')
                                            {{-- Enlaces/Botones de acción en azul --}}
                                            <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left"
                                            wire:click="assignDriver({{ $order->id }})">
                                                Asignar repartidor
                                            </button>
                                            @break
                                        @case('Shipped')
                                            <p class="text-green-600 text-left">
                                                "En camino"
                                            </p>
                                            @break
                                        @case('Failed')
                                            {{-- Enlaces/Botones de acción en azul --}}
                                            <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left"
                                            wire:click="markAsRefunded({{ $order->id }})">
                                                Marcar como devuelto
                                            </button>
                                            @break
                                        @case('Refunded')
                                            {{-- Enlaces/Botones de acción en azul --}}
                                            <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline text-left"
                                            wire:click="assignDriver({{ $order->id }})">
                                                Asignar repartidor
                                            </button>
                                            @break
                                        @default
                                    @endswitch
                                    
                                    @if ($order->status->name != 'Cancelled' && $order->status->name != 'Completed')
                                        {{-- Botón de Cancelar en rojo (por su función destructiva) --}}
                                        <button class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 hover:underline text-left"
                                        wire:click="cancelOrder({{ $order->id }})">
                                            Cancelar
                                        </button>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{-- PAGINATE--}}
        <div class="mt-4">
            {{$orders->links()}}
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
                <span class="font-medium">¡Alerta!</span> Todavia no hay ordenes registradas.
            </div>
        </div>

    @endif

    {{-- MODAL PARA ASIGNAR REPARTIDOR (Manteniendo la consistencia visual) --}}
    <x-dialog-modal wire:model.live="new_shipment.openModal">

        <x-slot name="title">
            Detalles de Orden
        </x-slot>

        <x-slot name="content">

            <x-label class="text-gray-700 dark:text-gray-300">
                Unidad
            </x-label>

            <x-select class="w-full border-blue-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="new_shipment.driver_id">

                <option value="" selected disabled>
                    Seleccione un repartidor
                </option>

                @foreach ($drivers as $driver)
                    <option value="{{ $driver->id }}">
                        {{ $driver->user->name }}
                    </option>
                @endforeach

            </x-select>

            <x-input-error for="new_shipment.driver_id" />

        </x-slot>

        <x-slot name="footer">

            {{-- Botón Cancelar en rojo (estilo de Laravel Breeze o Jetstream) --}}
            <x-danger-button wire:click="$set('new_shipment.openModal', false)">
                Cancelar
            </x-danger-button>

            {{-- Botón de acción principal en azul (consistente con el encabezado) --}}
            <x-button class="ml-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-900 focus:border-blue-900 focus:ring-blue-300" wire:click="saveShipment">
                Asignar
            </x-button>

        </x-slot>

    </x-dialog-modal>

    @if ($selectedOrder != null)
    {{-- MODAL PARA VER DETALLES --}}
    <x-dialog-modal wire:model.live="detailsModalOpen">

        <x-slot name="title">
            {{-- Detalle de la orden --}}
        </x-slot>

        <x-slot name="content">

            <div class="p-4 bg-white max-w-2xl mx-auto shadow-lg rounded-lg">
                <div class="mb-4">

                    @if ($selectedOrder)

                        <!-- HEADER Y METADATA DE LA ORDEN -->
                        <div class="grid grid-cols-2">
                            <div>
                                <strong class="text-gray-800 text-3xl mb-3">
                                    Orden #{{ $selectedOrder['id'] }}
                                </strong>
                            </div>

                            <div class="text-sm text-gray-600 text-right justify-end">
                                Fecha: <strong class="text-gray-800">
                                    {{ \Carbon\Carbon::parse($selectedOrder['created_at'])->format('d-m-Y') }}
                                </strong><br>

                                Estado: <strong class="text-green-600">COMPLETADO</strong>
                            </div>
                        </div>

                        <!-- SECCIÓN: DATOS DEL CLIENTE -->
                        <p class="font-bold text-base text-[#0b3b8e] mb-3 mt-5">Datos del cliente</p>
                        <div
                            class="text-sm text-gray-700 leading-relaxed mb-4 p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <!-- Estilo: margin-bottom:16px; -->
                            Nombre: <strong class="text-gray-900">{{ $selectedOrder['address']['receiver_info']['name'] }}
                                {{ $selectedOrder['address']['receiver_info']['last_name'] }}</strong><br>

                            @if($selectedOrder['address']['receiver_info']['document_type'] == 1)
                                DNI: <strong
                                    class="text-gray-900">{{ $selectedOrder['address']['receiver_info']['document_number'] }}</strong><br>
                            @else
                                CUIL: <strong
                                    class="text-gray-900">{{ $selectedOrder['address']['receiver_info']['document_number'] }}</strong><br>
                            @endif

                            Email: <strong class="text-gray-900">{{ $selectedOrder['user']['email'] }}</strong><br>
                            Teléfono: <strong
                                class="text-gray-900">{{ $selectedOrder['address']['receiver_info']['phone'] }}</strong><br>
                        </div>

                        <!-- SECCIÓN: DATOS DEL ENVIO -->
                        <p class="font-bold text-base text-[#0b3b8e] mb-3">Datos del envio</p>
                        <!-- Estilo: font-weight:700; color:#0b3b8e; -->
                        <div
                            class="text-sm text-gray-700 leading-relaxed mb-4 p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <!-- Estilo: margin-bottom:16px; -->
                            Dirección: <strong class="text-gray-900">{{ $selectedOrder['address']['description'] }}</strong><br>
                            Referencia: <strong class="text-gray-900">{{ $selectedOrder['address']['reference'] }}</strong><br>
                            Localidad: <strong class="text-gray-900">{{ $selectedOrder['address']['locality'] }}</strong><br>
                            Ciudad: <strong class="text-gray-900">{{ $selectedOrder['address']['province'] }}</strong><br>
                            Código Postal: <strong class="text-gray-900">{{ $selectedOrder['address']['postal_code'] }}</strong>
                        </div>

                        <!-- SECCIÓN: DETALLE DE LA COMPRA (TABLA DE PRODUCTOS) -->
                        <p class="font-bold text-base text-[#0b3b8e] mb-3">Detalle de la compra</p>

                        <table class="w-full table-auto border-collapse text-sm text-left rounded-lg">
                            <!-- Estilo: .table -->
                            <thead>
                                <tr class="bg-[#1e3a8a] text-white uppercase text-xs font-semibold tracking-wider">
                                    <th class="py-3 px-4">Producto</th>
                                    <th class="py-3 px-4 text-right">Precio</th>
                                    <th class="py-3 px-4 text-right">Cant.</th>
                                    <th class="py-3 px-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selectedOrder['products'] as $product)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-2 px-4">
                                            <a href="{{ route('products.show', $product['id']) }}">{{ $product['name'] }}</a>
                                        </td>
                                        <td class="py-2 px-4 text-right text-gray-800 font-medium">
                                            ${{ number_format($product['price'], 2) }}</td>
                                        <td class="py-2 px-4 text-right">{{ $product['qty'] }}</td>
                                        <td class="py-2 px-4 text-right font-bold text-gray-900">
                                            ${{ number_format($product['price'] * $product['qty'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- TOTAL PAGADO -->
                        <table role="presentation" class="w-full mt-3">
                            <!-- Estilo: margin-top:12px; -->
                            <tr class="bg-gray-100 border-t border-gray-300">
                                <td class="text-left font-bold text-sm py-3 px-4">Total pagado</td>
                                <!-- Estilo: font:700 14px Arial, ... -->
                                <td class="text-right font-extrabold text-lg text-[#0b3b8e] py-3 px-4">
                                    <!-- Estilo: font:800 16px Arial, ... -->
                                    ${{ number_format($selectedOrder['total'], 2) }}
                                </td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">

            <div class="flex justify-end space-x-2">

                <button class="btn btn-red" wire:click="$set('detailsModalOpen', false)">
                    Cerrar
                </button>

                <button class="btn btn-blue" wire:click="downloadInvoice({{ $selectedOrder['id'] }})">
                    Imprimir Factura
                </button>

            </div>
        </x-slot>

    </x-dialog-modal>
    @endif

</div>