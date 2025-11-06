<div class="bg-gray-50 dark:bg-gray-900 py-12">

<x-container class="md:flex px-8">

    @if (count($options))

        {{-- filtros --}}
        {{-- La barra lateral es sticky en md para que los filtros siempre estén accesibles --}}
        <aside class="w-full md:w-64 lg:w-72 md:flex-shrink-0 md:mr-8 mb-6 md:mb-0 p-6 bg-white dark:bg-gray-800 shadow-xl rounded-xl md:sticky md:top-8 md:h-fit">

            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4 pb-3 border-b border-gray-200 dark:border-gray-700">
                Filtros
            </h3>

            <ul class="space-y-4">
                @foreach ($options as $option)
                    <li class="mb-4 border-b border-gray-100 dark:border-gray-700 pb-4 last:border-b-0" x-data="{ open: false }">

                        {{-- Botón de Alternancia de Filtro --}}
                        <button
                            class="w-full flex justify-between items-center px-2 py-3 text-lg font-semibold text-gray-800 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-150 shadow-sm"
                            x-on:click="open = !open">

                            {{ $option['name'] }}

                            <i class="fa-solid fa-angle-down text-sm transition-transform duration-300" x-bind:class="{
                                        'rotate-0': !open,
                                        'rotate-180': open
                                    }"></i>
                        </button>


                        {{-- Opciones del Filtro --}}
                        <ul class="mt-3 space-y-3 px-1 text-sm text-gray-600 dark:text-gray-300" x-show="open" x-transition:enter.duration.300ms x-transition:leave.duration.300ms>
                            @foreach ($option['features'] as $feature)

                                <li>
                                    {{-- Mayor touch target para dispositivos móviles --}}
                                    <label class="inline-flex items-center space-x-2 cursor-pointer hover:text-blue-600 transition duration-100 w-full">

                                        <x-checkbox 
                                            value="{{ $feature['id'] }}" 
                                            wire:model.live="selected_features"
                                            class="mr-2 text-blue-600 focus:ring-blue-500 rounded-sm" />

                                        <span class="text-gray-700 dark:text-gray-300 text-lg">
                                            {{ $feature['description'] }}
                                        </span>
                                    </label>

                                </li>

                                
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

        </aside>

    @endif

    <div class="md:flex-1">

        {{-- Ordenar --}}
        {{-- Diseño responsive para apilar en pantallas muy pequeñas --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center p-4 bg-white dark:bg-gray-800 shadow-lg rounded-xl mb-6">

            <span class="mr-4 text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2 sm:mb-0 flex-shrink-0">
                Ordenar por:
            </span>

            <x-select wire:model.live="orderBy" class="w-full sm:w-auto mt-1 sm:mt-0 border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm">
                <option value="1">
                    Relevancia
                </option>
                <option value="2">
                    Precio: Mayor a menor
                </option>
                <option value="3">
                    Precio: Menor a mayor
                </option>
            </x-select>

        </div>

        <hr class="my-4 border-gray-300 dark:border-gray-700">

        {{-- LISTA DE PRODUCTOS --}}
        {{-- Se ajusta la densidad de columnas para diferentes tamaños de pantalla --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-6">

            @foreach ($products as $product)

                {{-- Tarjeta de Producto Estilizada --}}
                <article class="bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl rounded-xl overflow-hidden h-full flex flex-col transition duration-300 border border-gray-100 dark:border-gray-700 transform hover:scale-[1.01]">
                    {{-- Imagen del Producto --}}
                    <img src="{{ $product->image }}" class="w-full h-48 object-cover object-center flex-shrink-0" alt="">
                    
                    <div class="p-4 flex flex-col flex-grow">

                        {{-- Nombre del Producto --}}
                        <h2 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 line-clamp-2 mb-2 min-h-[56px]">
                            {{ $product->name }}
                        </h2>

                        {{-- Precio (Destacado) --}}
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4 mt-auto">
                            ${{ $product->price }}
                        </p>
                        
                        {{-- Botón Ver Más --}}
                        <a href="{{ route('products.show', $product) }}" 
                           class="w-full py-2.5 bg-blue-600 text-white font-semibold text-center rounded-lg hover:bg-blue-700 transition duration-300 block shadow-md shadow-blue-500/20">
                            Ver más
                        </a>
                    </div>
                </article>

            @endforeach
        </div>

        {{-- paginacion --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>

    </div>

</x-container>

</div>