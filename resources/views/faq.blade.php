<x-app-layout>
    <x-container>

        <div class="pt-4 max-w-screen-lg mx-auto min-h-screen">
            <div class="text-center mb-12">
                <p class="mt-4 text-sm leading-7 text-gray-500 font-regular">
                    F.A.Q
                </p>
                <h3 class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight text-gray-900">
                    Preguntas <span class="text-blue-600">Frecuentes</span>
                </h3>
            </div>

            <div class="px-10 sm:px-16">

                <div class="ml-5">

                    {{-- ciclo de FAQ desde el ADMIN --}}
                    <div class="flex items-start my-8">
                        <div
                            class="hidden sm:flex items-center justify-center p-3 mr-3 rounded-full bg-blue-600 text-white border-4 border-white text-xl font-semibold">
                            <svg width="24px" fill="white" height="24px" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <g data-name="Layer 2">
                                    <g data-name="menu-arrow">
                                        <rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect>
                                        <path
                                            d="M17 9A5 5 0 0 0 7 9a1 1 0 0 0 2 0 3 3 0 1 1 3 3 1 1 0 0 0-1 1v2a1 1 0 0 0 2 0v-1.1A5 5 0 0 0 17 9z">
                                        </path>
                                        <circle cx="12" cy="19" r="1"></circle>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="text-md">
                            <h1 class="text-gray-900 font-semibold mb-2">What might be your first question?</h1>
                            <p class="text-gray-500 text-sm">Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Maiores
                                impedit perferendis suscipit eaque, iste dolor cupiditate blanditiis ratione.</p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </x-container>
</x-app-layout>