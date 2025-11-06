<x-app-layout>

    <x-container class="px-4 my-4 min-h-[85vh]">

        {{-- Breadcrumb --}}

        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Inicio
                    </a>
                </li>

                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
                            Productos Encontrados
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Verifica si hay productos encontrados --}}

        @if ($products->count())

            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 my-6 md:me-6">
                Resultados de la búsqueda
            </h1>

            {{-- LISTA DE PRODUCTOS --}}

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">

                @foreach ($products as $product)

                    {{-- Tarjeta de Producto Estilizada --}}
                    <article
                        class="bg-white dark:bg-gray-800 shadow-xl hover:shadow-2xl rounded-xl overflow-hidden h-full flex flex-col transition duration-300 border border-gray-100 dark:border-gray-700 transform hover:scale-[1.01]">
                        {{-- Imagen del Producto --}}
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover object-center flex-shrink-0" alt="">

                        <div class="p-4 flex flex-col flex-grow">

                            {{-- Nombre del Producto --}}
                            <h2 class="text-xl font-extrabold text-gray-900 dark:text-gray-100 line-clamp-2 mb-2 min-h-[56px]">
                                {{ $product->name }}
                            </h2>

                            {{-- Precio (Destacado) --}}
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4 mt-auto">
                                ${{ number_format($product->price, 2) }}
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

        @else

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl mt-4 p-6 text-center w-full">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    No se encontraron productos
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Intenta con otro término de búsqueda.
                </p>
                <a href="/"
                    class="inline-block px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 shadow-md shadow-blue-500/20">
                    Volver al inicio
                </a>
            </div>

        @endif

    </x-container>
    
</x-app-layout>