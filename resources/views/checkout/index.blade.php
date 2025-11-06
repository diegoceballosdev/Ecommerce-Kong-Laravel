<x-app-layout>

    <div class="min-h-screen mb-16 text-gray-700" x-data="{ pago: 1 }">

        <div class="grid grid-cols-1 lg:grid-cols-2">

            <div class="col-span-1 ">

                <div class="lg:max-w-[40rem] grid grid-cols-1 py-12 px-4 lg:pr-8 sm:pl-6 lg:pl-8 ml-auto">

                    <h1 class="text-2xl font-semibold mb-2">
                        Pago
                    </h1>


                    <div class="shadow rounded-lg overflow-hidden border border-gray-400">

                        <ul class="divide-y divide-gray-400">
                            <li>
                                <label class="p-4 flex items-center">
                                    <input type="radio" value="1" x-model="pago" class="text-blue-600">

                                    <span class="ml-2">Tarjeta de debito / credito</span>

                                    <img src="{{ asset('img/pagos.png') }}" alt="" class="h-6 ml-auto">
                                </label>

                                <div class="p-4 bg-gray-100 text-center border-t border-gray-400" x-cloak
                                    x-show="pago == 1">

                                    <i class="fa-regular fa-credit-card text-9xl"></i>

                                    <p class="mt-2">Luego de hacer click en pagar, se abrirá el checkou de Niubiz para
                                        completar la compra</p>

                                </div>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>



            <div class="col-span-1">

                <div class="lg:max-w-[40rem] py-12 px-4 lg:pl-8 sm:pr-6 lg:pr-8 mr-auto">

                    <ul>
                        @foreach ($content as $item)

                            <ul class="space-y-4 bb-4">

                                <li class="flex items-center space-x-4 py-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->options->image }}" alt="{{ $item->name }}"
                                            class="h-16 w-16 object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-md font-semibold">{{ $item->name }}</p>
                                        <p class="text-gray-600 text-sm">Cantidad: {{ $item->qty }}</p>
                                        <p class="text-gray-600 text-sm">Precio: ${{ $item->price }}</p>
                                    </div>

                                </li>

                            </ul>

                        @endforeach

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

                            <div class="mt-6">

                                <button class="btn btn-blue w-full" onclick="VisanetCheckout.open()">
                                    Finalizar pedido
                                </button>

                            </div>

                            @if(session('niubiz'))

                                @php
                                    $niubiz = session('niubiz');
                                    $response = $niubiz['response'] ?? null;
                                    $purchaseNumber = $niubiz['purchaseNumber'] ?? null;
                                @endphp

                                @isset($response['data'])

                                <div class="mt-6 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg shadow-lg">

                                    <h2 class="text-lg font-semibold mb-2 mt-2">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        Pago Fallido
                                    </h2>

                                    <p>
                                        {{$response['data']['ACTION_DESCRIPTION'] ?? 'Hubo un problema con tu pago.'}}
                                    </p>

                                    <p>
                                        <b>Número de pedido: </b> {{$purchaseNumber}}
                                    </p>

                                    <p>
                                        <b>Fecha y hora del pedido: </b> {{
                                            now()->createFromFormat('ymdHis', $response['data']['TRANSACTION_DATE'])->format('d/m/Y H:i:s') 
                                        }}
                                    </p>

                                    @isset($response['data']['CARD'])
                                        <p>
                                            <b>Tarjeta: </b> {{ $response['data']['CARD'] }} ({{ $response['data']['BRAND'] }})
                                        </p>
                                    @endisset

                                </div>

                                @endisset

                            @endif

                        
                    </ul>
                </div>
            </div>

        </div>
    </div>

    @push('js')

        <script type="text/javascript" src="{{config('services.niubiz.url_js')}}"></script>

        <script type="text/javascript">

        let purchasenumber = Math.floor(Math.random() * 1000000000);

        // Formatear el subtotal para que devuelva el decimal con punto y no con coma
        let amount = {{ $total}};

            document.addEventListener("DOMContentLoaded", function (event) {

                VisanetCheckout.configure({
                    sessiontoken: '{{$session_token}}',
                    channel: 'web',
                    merchantid: "{{config(key: 'services.niubiz.merchant_id')}}",
                    purchasenumber: purchasenumber,
                    amount: amount,
                    expirationminutes: '20',
                    timeouturl: 'about:blank',
                    merchantlogo: 'img/comercio.png',
                    formbuttoncolor: '#000000',
                    action: "{{ route('checkout.paid') }}?amount=" + amount + "&purchaseNumber=" + purchasenumber,
                    complete: function (params) {
                        alert(JSON.stringify(params));
                    }
                });

            });

        </script>

    @endpush

</x-app-layout>