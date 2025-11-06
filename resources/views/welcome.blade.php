<x-app-layout>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    @endpush

    {{-- SLIDER DE COVERS (BANNERS PRINCIPALES) --}}
    <div class="swiper swiper-covers shadow overflow-hidden">
        <div class="swiper-wrapper">
            @foreach ($covers as $cover)
                <div class="swiper-slide">
                    <img src="{{$cover->image}}" alt="" class="w-full object-cover object-center">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination covers-pagination"></div>
    </div>

    {{-- CONTENIDO PRINCIPAL --}}

    <!-- SECCIÓN 1: CATEGORÍAS DESTACADAS -->
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Categorías Populares</h3>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Encuentra todo lo que necesitas
                    para tu equipamiento profesional</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Categoría 1: Uniformes -->
                <div
                    class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:border-blue-500 transition-all duration-300 transform hover:scale-[1.03]">
                    <div class="text-blue-600 dark:text-blue-400 text-6xl mb-4 inline-block">
                        <i class="fa-solid fa-shirt"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">Uniformes</h3>
                    <p class="text-gray-600 dark:text-gray-400">Resistencia y comodidad para el servicio diario.</p>
                </div>
                <!-- Categoría 2: Calzado -->
                <div
                    class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:border-blue-500 transition-all duration-300 transform hover:scale-[1.03]">
                    <div class="text-blue-600 dark:text-blue-400 text-6xl mb-4 inline-block">
                        <i class="fa-solid fa-shoe-prints"></i> {{-- Icono cambiado a uno más adecuado para calzado --}}
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">Calzado</h3>
                    <p class="text-gray-600 dark:text-gray-400">Botas tácticas para todo tipo de terreno y situación.
                    </p>
                </div>
                <!-- Categoría 3: Accesorios -->
                <div
                    class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:border-blue-500 transition-all duration-300 transform hover:scale-[1.03]">
                    <div class="text-blue-600 dark:text-blue-400 text-6xl mb-4 inline-block">
                        <i class="fa-solid fa-toolbox"></i> {{-- Icono cambiado a uno más adecuado para accesorios --}}
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">Accesorios</h3>
                    <p class="text-gray-600 dark:text-gray-400">Todo lo indispensable: linternas, guantes y más.</p>
                </div>
                <!-- Categoría 4: Equipamiento -->
                <div
                    class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 hover:shadow-2xl hover:border-blue-500 transition-all duration-300 transform hover:scale-[1.03]">
                    <div class="text-blue-600 dark:text-blue-400 text-6xl mb-4 inline-block">
                        <i class="fa-solid fa-helmet-safety"></i> {{-- Icono cambiado a uno más adecuado para
                        equipamiento --}}
                    </div>
                    <h3 class="text-2xl font-bold mb-2 text-gray-800 dark:text-gray-100">Equipamiento</h3>
                    <p class="text-gray-600 dark:text-gray-400">Tecnología y protección para misiones críticas.</p>
                </div>
            </div>
        </div>
    </section>


    {{-- SECCIÓN 2: Mas vendidos (SLIDER) --}}
    <section id="productos" class="py-14 bg-gray-100 dark:bg-gray-800 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Productos Destacados</h3>
            <p class="text-xl text-gray-600 dark:text-gray-400">Los más elegidos por profesionales</p>
        </div>

        <div class="container mx-auto px-6 lg:px-10">

            <div class="swiper swiper-products relative py-4">
                <div class="swiper-wrapper pb-10">
                    @foreach ($lastProducts as $product)
                        <div class="swiper-slide">
                            {{-- Tarjeta de producto con sombra y borde sutil azul --}}
                            <article
                                class="bg-white dark:bg-gray-900 shadow-xl rounded-xl overflow-hidden h-full flex flex-col transition duration-300 hover:shadow-blue-500/30 dark:hover:shadow-blue-900/40 hover:scale-[1.02] border border-gray-200 dark:border-gray-700">

                                <img src="{{ $product->image }}"
                                    class="w-full h-48 object-cover object-center flex-shrink-0" alt="{{ $product->name }}">
                                <div class="p-4 flex flex-col flex-grow">

                                    <h2
                                        class="text-xl font-bold text-gray-800 dark:text-gray-100 line-clamp-2 mb-2 min-h-[56px] flex-grow">
                                        {{ $product->name }}
                                    </h2>

                                    {{-- Precio resaltado en color azul --}}
                                    <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mb-4 mt-auto">
                                        ${{ number_format($product->price, 2, ',', '.') }}
                                    </p>

                                    {{-- Botón de acción principal en azul --}}
                                    <a href="{{ route('products.show', $product) }}"
                                        class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-md shadow-blue-500/20 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition w-full">
                                        Ver más
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                {{-- Controles propios del slider de productos (más visible) --}}
                <div class="swiper-pagination products-pagination !bottom-0 !left-1/2 !-translate-x-1/2"></div>

            </div>
        </div>
    </section>


    {{-- SECCIÓN 3: BENEFICIOS/CARACTERÍSTICAS (Placeholder) --}}
    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-6  max-w-7x">

            <div class=" swiper swiper-info relative">

                <div class="swiper-wrapper text-center">

                    {{-- Beneficio 1 --}}
                    <div
                        class="swiper-slide px-8 py-8 rounded-xl">
                        <div class="text-7xl text-blue-500 dark:text-blue-400 mb-4">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-gray-800 dark:text-gray-100 mb-2">Envío Rápido y Seguro
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">Entregas garantizadas a todo el país.</p>
                    </div>

                    {{-- Beneficio 2 --}}
                    <div
                        class="swiper-slide px-8 py-8 rounded-xl">
                        <div class="text-7xl text-blue-500 dark:text-blue-400 mb-4">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-gray-800 dark:text-gray-100 mb-2">Garantía Total</h3>
                        <p class="text-gray-600 dark:text-gray-400">Devoluciones y cambios sin complicaciones.</p>
                    </div>

                    {{-- Beneficio 3 --}}
                    <div
                        class="swiper-slide px-8 py-8 rounded-xl ">
                        <div class="text-7xl text-blue-500 dark:text-blue-400 mb-4">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <h3 class="font-extrabold text-xl text-gray-800 dark:text-gray-100 mb-2">Soporte Premium</h3>
                        <p class="text-gray-600 dark:text-gray-400">Asistencia personalizada todos los dias.</p>
                    </div>
                </div>
                <div class="swiper-pagination info-pagination"></div>
            </div>
        </div>
    </section>


    {{-- SECCIÓN 4: ÚLTIMOS PRODUCTOS (SLIDER) --}}
    <section id="productos" class="py-14 bg-gray-100 dark:bg-gray-800 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Últimos Productos Agregados</h3>
            <p class="text-xl text-gray-600 dark:text-gray-400">Descubre nuestras últimas incorporaciones</p>
        </div>
        <div class="container mx-auto px-6 lg:px-10">

            <div class="swiper swiper-products relative py-4">
                <div class="swiper-wrapper pb-10">
                    @foreach ($lastProducts as $product)
                        <div class="swiper-slide">
                            {{-- Tarjeta de producto con sombra y borde sutil azul --}}
                            <article
                                class="bg-white dark:bg-gray-900 shadow-xl rounded-xl overflow-hidden h-full flex flex-col transition duration-300 hover:shadow-blue-500/30 dark:hover:shadow-blue-900/40 hover:scale-[1.02] border border-gray-200 dark:border-gray-700">

                                <img src="{{ $product->image }}"
                                    class="w-full h-48 object-cover object-center flex-shrink-0" alt="{{ $product->name }}">
                                <div class="p-4 flex flex-col flex-grow">

                                    <h2
                                        class="text-xl font-bold text-gray-800 dark:text-gray-100 line-clamp-2 mb-2 min-h-[56px] flex-grow">
                                        {{ $product->name }}
                                    </h2>

                                    {{-- Precio resaltado en color azul --}}
                                    <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400 mb-4 mt-auto">
                                        ${{ number_format($product->price, 2, ',', '.') }}
                                    </p>

                                    {{-- Botón de acción principal en azul --}}
                                    <a href="{{ route('products.show', $product) }}"
                                        class="inline-flex items-center justify-center px-4 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider shadow-md shadow-blue-500/20 hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition w-full">
                                        Ver más
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                {{-- Controles propios del slider de productos --}}
                <div class="swiper-pagination products-pagination !bottom-0 !left-1/2 !-translate-x-1/2"></div>

            </div>
        </div>
    </section>


    {{-- SECCIÓN 5: BANNER DE PROMOCIÓN / CTA (Placeholder) --}}
    <section id="contacto" class="bg-blue-700 dark:bg-blue-900 shadow-inner">
        <div class="container mx-auto px-6 py-16 text-center text-white">
            <h3 class="text-4xl sm:text-5xl font-extrabold mb-6 leading-tight">¿Necesitas Asesoramiento Personalizado?
            </h3>
            <p class="text-xl text-blue-200 mb-10 max-w-3xl mx-auto">
                Nuestros expertos te ayudan a encontrar el equipamiento perfecto para tus necesidades profesionales
            </p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center justify-center bg-white text-blue-700 font-extrabold text-lg py-3 px-10 rounded-xl shadow-xl hover:bg-blue-50 transition duration-300 transform hover:scale-105">
                Contactar a un Especialista
            </a>
        </div>
    </section>


    {{-- Script de Swiper original (sin modificar) --}}
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

        <script>
            // Covers
            const coverSwiper = new Swiper('.swiper-covers', {
                loop: true,
                autoplay: { delay: 3000 },
                pagination: { el: '.covers-pagination', clickable: true },
                // navigation: { nextEl: '.covers-next', prevEl: '.covers-prev' },
                dynamicBullets: true,
            });

            // Beneficios
            const infoSwiper = new Swiper('.swiper-info', {
                loop: false,
                autoplay: { delay: 3000 },
                watchOverflow: true,
                spaceBetween: 16,
                dynamicBullets: true,
                slidesPerView: 1,
                breakpoints: {
                    640: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
                //pagination: { el: '.info-pagination', clickable: true },
                // navigation: { nextEl: '.info-next', prevEl: '.info-prev' },
            });


            // Productos
            const productsSwiper = new Swiper('.swiper-products', {
                loop: false,
                autoplay: { delay: 3000 },
                watchOverflow: true,
                spaceBetween: 16,
                dynamicBullets: true,
                slidesPerView: 1,
                breakpoints: {
                    480: { slidesPerView: 2 }, // xs
                    768: { slidesPerView: 3 }, // md
                    1024: { slidesPerView: 4 }, // lg+
                    1280: { slidesPerView: 5 }, // xl
                },
                pagination: { el: '.products-pagination', clickable: true },

                //navigation: { nextEl: '.products-next', prevEl: '.products-prev' },
            });
        </script>
    @endpush

</x-app-layout>