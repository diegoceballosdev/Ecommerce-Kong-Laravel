<x-app-layout>
    <x-container>

        {{-- Detalles de la transacción obtenidos de la RESPONSE --}}
        @php
            // Extrae seguro desde sesión
            $niubiz = session('niubiz');
            $response = data_get($niubiz, 'response', []);

            // Campos con fallback
            $action = data_get($response, 'dataMap.ACTION_DESCRIPTION');
            $purchase = data_get($response, 'order.purchaseNumber');
            $amount = data_get($response, 'order.amount');
            $currency = data_get($response, 'order.currency');
            $card = data_get($response, 'dataMap.CARD');
            $brand = data_get($response, 'dataMap.BRAND');
            $txDate = data_get($response, 'dataMap.TRANSACTION_DATE'); // ymdHis

            // Parseo seguro de fecha
            try {
                $dateHuman = $txDate
                    ? \Carbon\Carbon::createFromFormat('ymdHis', $txDate)->format('d/m/Y H:i:s')
                    : null;
            } catch (\Throwable $e) {
                $dateHuman = null;
            }
        @endphp

        <section class="min-h-[60vh] grid place-items-center py-12">

            <div class="w-full max-w-3xl rounded-2xl border border-slate-200/60 bg-white p-6 shadow-lg
                  dark:border-slate-700/60 dark:bg-slate-900">


                <!-- Encabezado -->
                <div class="flex items-start gap-4">


                    <div
                        class="grid h-12 w-12 place-items-center rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 text-white shadow-lg">

                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>

                    </div>

                    <div>

                        <h1 class="text-2xl font-semibold leading-tight text-slate-900 dark:text-slate-100">
                            Gracias por tu compra
                        </h1>
                        <p class="mt-1 text-slate-600 dark:text-slate-300">
                            Tu pago ha sido procesado exitosamente.
                        </p>

                    </div>

                </div>

                <div class="mt-6">


                    {{-- Alerta si no hay sesión o no trae la estructura esperada --}}
                    @if (!$niubiz || empty($response))
                        <div class="rounded-xl border border-amber-300/40 bg-amber-50 p-4 text-amber-800
                            dark:border-amber-400/30 dark:bg-amber-900/20 dark:text-amber-200">
                            <p class="text-sm">
                                No encontramos los datos del pago en la sesión. Es posible que la página se haya recargado o
                                que el flujo no haya enviado la información.
                            </p>
                        </div>
                    @endif


                    {{-- Descripción / Mensaje de la pasarela --}}
                    <div class="mt-4 rounded-xl border border-slate-200/70 bg-slate-50 p-4 text-slate-700
                      dark:border-slate-700/60 dark:bg-slate-800/60 dark:text-slate-200">
                        <p class="text-sm">
                            {{ $action ?? 'Pago aprobado' }}
                        </p>
                    </div>


                    <!-- Detalles del pago -->
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">


                        {{-- NUMERO DE PEDIDO --}}
                        <div class="rounded-xl border border-slate-200/70 bg-white p-4
                        dark:border-slate-700/60 dark:bg-slate-900/40">

                            <span class="block text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Número de pedido
                            </span>

                            <div class="mt-1 flex items-center gap-2">

                                <b class="text-slate-900 dark:text-slate-100">
                                    {{ $purchase ?? '—' }}
                                </b>

                                @if (!empty($purchase))

                                            <button type="button" class="inline-flex items-center rounded-md border border-slate-200 px-2 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50 active:scale-[.99]
                                       dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                                                data-copy="{{ $purchase }}"
                                                onclick="navigator.clipboard.writeText(this.dataset.copy)">
                                                Copiar
                                            </button>

                                @endif
                            </div>

                        </div>


                        {{-- FECHA Y HORA --}}
                        <div class="rounded-xl border border-slate-200/70 bg-white p-4
                        dark:border-slate-700/60 dark:bg-slate-900/40">
                            <span class="block text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Fecha y hora
                            </span>
                            <b class="mt-1 block text-slate-900 dark:text-slate-100">
                                {{ $dateHuman ?? '—' }}
                            </b>
                        </div>

                        {{-- TARJETA --}}
                        <div class="rounded-xl border border-slate-200/70 bg-white p-4
                        dark:border-slate-700/60 dark:bg-slate-900/40">
                            <span class="block text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Tarjeta
                            </span>
                            <b class="mt-1 block text-slate-900 dark:text-slate-100">
                                @if (!empty($card) || !empty($brand))
                                    {{ $card ?? '—' }}{{ !empty($card) && !empty($brand) ? ' ' : '' }}{{ !empty($brand) ? "({$brand})" : '' }}
                                @else
                                    —
                                @endif
                            </b>
                        </div>

                        {{-- IMPORTE --}}
                        <div class="rounded-xl border border-slate-200/70 bg-white p-4
                        dark:border-slate-700/60 dark:bg-slate-900/40">
                            <span class="block text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Importe
                            </span>
                            <b class="mt-1 block text-slate-900 dark:text-slate-100">
                                @if (!is_null($amount) && !empty($currency))
                                    {{ $amount }} ${{ $currency }}
                                @elseif (!is_null($amount))
                                    {{ $amount }}
                                @else
                                    —
                                @endif
                            </b>
                        </div>
                    </div>


                    <!-- Acciones -->

                    <div class="mt-8 justify-center flex flex-wrap items-center gap-6">

                        <a href="{{ route('welcome.index') }}" class="btn btn-blue">
                            Volver al inicio
                        </a>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline">
                            Ver comprobante
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </x-container>

</x-app-layout>