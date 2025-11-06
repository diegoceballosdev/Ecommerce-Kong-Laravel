<x-app-layout>
    <x-container class="mt-12 px-4 min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- seccion de direcciones --}}
            <div class="col-span-2">

                @livewire('shipping-addresses')

            </div>

            {{-- seccion de vista de carrito y pago --}}
            <div class="col-span-1">

                <div class="bg-white rounded-lg shadow overflow-hidden mb-4">

                    <div class="bg-blue-800 text-white p-3 flex justify-between items-center gap-2">

                        <p class="font-semibold">
                            Resumen de compra ({{ $content->count()}})
                        </p>

                        <a href="{{ route('cart.index') }}" class="fa-solid fa-cart-shopping"></a>
                    </div>

                    <div class="p-4 text-gray-600">

                        <ul>
                            @foreach ($content as $item)
                                <li class="flex items-center space-x-2 border-gray-200 mb-4">
                                    <figure class="shrink-0">
                                        <img class="h-10 w-10 object-cover object-center"
                                            src="{{ $item->options->image }}" alt="">
                                    </figure>

                                    <div class="flex-1">

                                        <p class="text-sm">
                                            {{ $item->name }}
                                        </p>

                                        <p class="text-sm">
                                            {{ $item->qty }} x ${{ $item->price }}
                                        </p>

                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <hr class="my-4">

                            <div class="flex justify-between items-center">
                                <p>Subtotal</p>
                                <p class="">
                                    ${{$subtotal }}
                                </p>
                            </div>

                            <div class="flex justify-between">
                                <p>
                                    Costo de Envío
                                    <i class="fas fa-info-circle ml-2" title="Costo de Envío aplicado"></i>
                                </p>

                                <p class="">
                                    {{ $shipping }}
                                </p>
                            </div>

                            <hr class="my-4">

                            <div class="flex justify-between items-center">
                                <p class="">
                                    Total
                                </p>
                                <p class="text-2xl font-bold text-gray-800">
                                    ${{ $total }}
                                </p>

                            </div>

                    </div>
                </div>

                @if ($address == null)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" >
                        <strong class="font-bold">¡Atención!</strong>
                        <span class="block sm:inline">Debe seleccionar una dirección de envío para continuar con la compra.</span>
                    </div>
                @else
                    {{-- Niubiz --}}
                    <div class="mt-6">
                        <p class="font-semibold mb-2">
                            Finalizar compra con: 
                        </p>

                        <a href="{{ route('checkout.index') }}" class="btn btn-blue w-full block text-center text-lg">
                            Niubiz
                        </a>
                    </div>

                    {{-- Mercado Pago --}}
                    <div class="mt-6">
                        <p class="font-semibold ">
                            Finalizar compra con: 
                        </p>
                        <div id="walletBrick_container"></div>

                    </div>
                @endif



            </div>
        </div>

    </x-container>

    @push('js')

        {{-- SDK de Mercado Pago --}}
        <script src="https://sdk.mercadopago.com/js/v2"></script>

        <script>

                const mp = new MercadoPago("{{config('services.mercadopago.public_key')}}");

                const bricksBuilder = mp.bricks();

                mp.bricks().create("wallet", "walletBrick_container", {
                    initialization: {
                        preferenceId: "{{$preferenceId}}",
                        // redirectMode: "modal",
                    },
                    customization:{
                        theme: 'default',
                        // texts:{
                        //     action: 'buy'
                        //     valueProp: 'security_details'
                        // },
                        // visual:{
                        //     buttonBackground: 'black',
                        //     borderRadius: '26px',
                        //     buttonHeight: '48px',
                        //     valuePropColor: 'white',
                        // }
                    }
                });

        </script>
        
    @endpush

</x-app-layout>