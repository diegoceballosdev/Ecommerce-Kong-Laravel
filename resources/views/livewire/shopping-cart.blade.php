<div class="min-h-screen">

    <div class="grid grid-cols-1 lg:grid-cols-7 gap-6 mb-16">

        {{-- Lista de Productos (Columna Izquierda) --}}
        <div class="lg:col-span-5">

            <div class="justify-between flex items-center mb-4 gap-4">
                <h1 class="text-2xl font-extrabold mb-4 pt-3">
                    Carrito de compras ( {{ Cart::count() }} )
                </h1>

                <button class="btn btn-red font-extrabold text-lg rounded-xl"
                wire:click="destroyCart">
                    Limpiar carrito
                </button>
            </div>

            <div class="card shadow-lg">

                <ul class="space-y-8">

                    @forelse (Cart::content() as $item)

                        <li class="flex flex-col sm:flex-row gap-4 {{$item->qty > $item->options['stock'] ? 'text-red-600 bg-red-100 p-2 rounded-lg' : ''}}">

                            <img class="w-24 h-24 aspect-[1/1] object-cover object-center" src="{{ $item->options->image }}" alt="">

                            <div class="w-80">

                                @if ($item->qty > $item->options['stock'])

                                <p class="text-red-600 font-semibold mb-2 items-center underline">¡ERROR: Stock insuficiente!</p>

          
                                @endif

                                <p class="mb-2 truncate font-semibold text-lg">
                                    <a href="{{ route('products.show', $item->id) }}">
                                        {{ $item->name }}
                                    </a>
                                </p>

                                <p class="mb-2">
                                    @foreach ($item->options->features as $feature)
                                        <span class="text-sm text-gray-500 bg-gray-100 p-1 rounded-md mr-1">
                                            {{ $feature }}
                                        </span>
                                    @endforeach
                                </p>

                                <p class="text-sm  mb-2 text-blue-600">
                                    Precio: ${{ number_format($item->price, 2) }}
                                </p>

                                <button
                                    class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-1 rounded-md text-xs flex items-center gap-1"
                                    wire:click="removeProduct('{{ $item->rowId }}')">

                                    <i class="fas fa-trash"></i>
                                    Eliminar
                                </button>

                            </div>

                            <div class="sm:ml-auto space-x-2 flex items-center">

                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-md text-lg flex items-center"
                                    wire:click="decrease('{{ $item->rowId }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="decrease('{{ $item->rowId }}')"
                                    @disabled($item->qty == 1)>
                                    {{-- rowId es una cadena por eso se pasa entre comillas, y es un identificador unico del item 
                                    --}}
                                    -
                                </button>

                                <span class=" inline-block w-3 text-center">
                                    {{ $item->qty }}
                                </span>

                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-md text-lg flex items-center"
                                    wire:click="increase('{{ $item->rowId }}')"
                                    wire:loading.attr="disabled"
                                    wire:target="increase('{{ $item->rowId }}')"
                                    @disabled($item->qty >= $item->options['stock'])>
                                    {{-- rowId es una cadena por eso se pasa entre comillas, y es un identificador unico del item 
                                    --}}
                                    +
                                </button>

                            </div>


                        </li>
                    @empty
                        {{-- Carrito Vacío --}}
                        <li class="py-16 text-center">
                            <i class="fas fa-shopping-bag text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <p class="text-xl font-medium text-gray-600 dark:text-gray-400">
                                No hay productos en el carrito.
                            </p>
                        </li>
                    @endforelse

                </ul>

            </div>

        </div>

        {{-- Resumen de la Orden (Columna Derecha) --}}
        <div class="lg:col-span-2">

            <div class="card shadow-lg">
                <div class="flex justify-between font-semibold mb-4">
                    <span class="text-xl">Subotal: </span>
                    <span class="text-xl">${{ $this->subtotal }}</span>
                </div>

                @if (Cart::count() > 0 && $this->subtotal > 0)
                
                <a href="{{ route('shipping.index') }}" class="btn btn-blue w-full block text-center font-extrabold text-lg rounded-xl">
                    Iniciar compra
                </a>

                @else

                <p class="text-gray-600 dark:text-gray-400 mb-2">
                    Agrega productos al carrito para poder continuar con la compra.
                </p>

                <a href="/" class="btn btn-gray w-full block text-center">
                    Volver al inicio
                </a>

                @endif

            </div>


        </div>

    </div>
</div>