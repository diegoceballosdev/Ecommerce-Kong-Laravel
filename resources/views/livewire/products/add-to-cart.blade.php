<div>

    {{-- Producto --}}
    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 mb-2">
        {{ $product->name }}
    </h1>
    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 pb-4 ">
        SKU: <span class="font-semibold">{{ $product->sku }}</span>
    </div>

    {{-- estrellas --}}
    <div class="flex items-center space-x-3 mb-4">
        <ul class="flex space-x-0.5 text-sm">
            <li>
                <i class="fa-solid fa-star text-yellow-400"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-400"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-400"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-yellow-400"></i>
            </li>
            <li>
                <i class="fa-solid fa-star text-gray-300 dark:text-gray-600"></i> {{-- Ejemplo de estrella vacía --}}
            </li>
        </ul>
        <p class="text-sm text-gray-600 dark:text-gray-300 font-medium">
            4.7 (55 Reseñas)
        </p>
    </div>

    {{-- Precio y stock --}}
    <div class="flex justify-between items-end border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
        <p class="text-4xl font-extrabold text-blue-700 dark:text-blue-400">
            ${{ number_format($product->price, 2, ',', '.') }}
        </p>

        {{-- Estado de Stock --}}
        @if ($stock > 0)
            <p class="text-sm font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/50 px-3 py-1 rounded-full">
                En stock: {{ $stock }}
            </p>
        @else
            <p class="text-sm font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/50 px-3 py-1 rounded-full">
                Agotado
            </p>
        @endif
    </div>

    {{-- VARIANTES DEL PRODUCTO --}}
    <div class="grid grid-cols-1 border-b pb-4 mb-4 border-gray-200 dark:border-gray-700">
        @foreach ($product->options as $option)
            <div class="mr-8 mb-4">
                <p class="font-bold text-lg text-gray-800 dark:text-gray-200 mb-3">
                    {{ $option->name }}:
                </p>
                <ul class="flex items-center space-x-3">
                    @foreach ($option->pivot->features as $feature)
                        <li>
                            @switch($option->type)
                                @case(1) {{-- Opción de Texto --}}
                                    <button
                                        class="px-5 py-2 font-semibold uppercase text-xs rounded-full border-2 transition duration-200
                                        {{$selectedFeatures[$option->id] == $feature['id'] 
                                            ? 'bg-blue-600 text-white border-blue-600 shadow-md' 
                                            : 'bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700'}}
                                        "
                                        wire:click="$set('selectedFeatures.{{ $option->id }}', '{{ $feature['id'] }}')">
                                        {{ $feature['value'] }}
                                    </button>    
                                    @break
                                @case(2) {{-- Opción de Color --}}
                                    <div class="p-0.5 rounded-full flex items-center border-2 transition duration-200 
                                        {{$selectedFeatures[$option->id] == $feature['id'] ? 'border-blue-600 dark:border-blue-400 ring-2 ring-blue-300 dark:ring-blue-600' : 'border-transparent'}}">
                                        
                                        <button class="w-8 h-8 rounded-full border border-gray-300 shadow-inner"
                                            style="background-color: {{ $feature['value'] }};"
                                            wire:click="$set('selectedFeatures.{{ $option->id }}', '{{ $feature['id'] }}')">
                                        </button>
                                    </div>
                                    @break
                                @default
                                    
                            @endswitch
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 justify-between">

        {{-- Selector de cantidad --}}
        <div class="flex space-x-4 pt-2 mb-6 items-center"
            x-data="{ 
                quantity: @entangle('quantity'),
                stock: @entangle('stock'),
                }">
            
            <p class="font-semibold text-gray-700 dark:text-gray-300">Cantidad:</p>

            {{-- Botón Restar --}}
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold text-xl transition duration-150 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed" 
                    x-on:click="quantity--" 
                    x-bind:disabled="quantity == 1">
                -
            </button>

            {{-- Display Cantidad --}}
            <span class="inline-block w-6 text-center text-lg font-bold text-gray-800 dark:text-gray-100" x-text="quantity">
            </span>

            {{-- Botón Sumar --}}
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold text-xl transition duration-150 hover:bg-gray-300 disabled:opacity-50 disabled:cursor-not-allowed" 
                    x-on:click="quantity++" 
                    :disabled="quantity >= stock">
                +
            </button>

        </div>
        
        {{-- envio --}}
        <div class="text-gray-700 dark:text-gray-300 flex items-center space-x-3 mb-6 p-3 dark:bg-gray-700/50 rounded-lg">
            <i class="fa-solid fa-truck-fast text-2xl text-blue-600 dark:text-blue-400"></i>
            <p class="text-sm font-medium">Envío gratis en pedidos mayores a $100.000,00</p>
        </div>

    </div>

    {{-- Botón Añadir al Carrito --}}
    <button class="w-full mb-4 py-3 bg-blue-600 text-white font-extrabold text-lg rounded-xl shadow-xl shadow-blue-500/30 dark:shadow-blue-900/50 
                hover:bg-blue-700 transition duration-300 uppercase tracking-wider
                disabled:bg-gray-400 disabled:shadow-none disabled:cursor-not-allowed"
        wire:click="addToCart" 
        wire:loading.attr="disabled"
        @if($stock <= 0) disabled @endif>
        
        {{-- Texto del botón --}}
        <span wire:loading.remove>
            {{ $stock > 0 ? 'Agregar al carrito' : 'Producto Agotado' }}
        </span>
        
        {{-- Indicador de carga --}}
        <span wire:loading>
            Procesando...
        </span>
    </button>


</div>
