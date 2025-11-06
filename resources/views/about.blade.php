<x-app-layout>

    <x-container>

        <section class="relative bg-gray-100 py-10 px-8 overflow-hidden min-h-screen">

            <!-- Content Container -->
            <div
                class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 items-center p-8 bg-white bg-opacity-90 rounded-xl shadow-lg backdrop-blur-lg hover:scale-105 transform transition duration-300 ease-in-out">
                
                <!-- Text Content -->
                <div class="col-span-1">
                    <h2 class="text-4xl font-extrabold text-gray-800 mb-4">¿Quiénes somos?</h2>
                    <p class="text-gray-600 mb-6 text-lg">
                        En Kong trabajamos con un propósito claro: brindar a las fuerzas de seguridad,
                        profesionales y entusiastas, productos de máxima calidad que respondan a las exigencias del día
                        a día.

                        Nos especializamos en indumentaria, equipamiento y accesorios policiales y tácticos,
                        seleccionados cuidadosamente para garantizar seguridad, resistencia y confianza en cada
                        situación.
                    </p>
                    <div class="space-y-6 mb-6">
                        <!-- Card for each feature -->
                        <div
                            class="bg-gray-100 flex items-center space-x-4 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div class="">
                                <h3 class="text-xl font-semibold">Calidad</h3>
                                <p class="text-sm">Trabajamos con materiales y marcas de primera línea.</p>
                            </div>
                        </div>

                        <div
                            class="bg-gray-100 flex items-center space-x-4 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-700">Confianza y respaldo</h3>
                                <p class="text-gray-500 text-sm">Cada producto está pensado para acompañar el desempeño
                                    en el terreno laboral.</p>
                            </div>
                        </div>

                        <div
                            class="bg-gray-100 flex items-center space-x-4 p-4 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-700">Innovación constante</h3>
                                <p class="text-gray-500 text-sm">Actualizamos nuestro catálogo para mantenerte siempre
                                    equipado con lo mejor.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div class="col-span-1">

                    <img src="/img/kong2.png" alt="About Us"
                        class="relative rounded-xl shadow-xl object-cover w-full h-full hover:opacity-90 transition-opacity duration-300" />

                </div>
            </div>
        </section>

    </x-container>

</x-app-layout>