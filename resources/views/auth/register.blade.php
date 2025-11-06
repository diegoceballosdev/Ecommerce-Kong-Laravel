<x-guest-layout>

<x-authentication-card class="shadow-2xl dark:shadow-none dark:bg-gray-800/90 backdrop-blur-md rounded-3xl p-8 sm:p-10 w-full max-w-xl lg:max-w-2xl mx-auto border border-gray-200 dark:border-gray-700 transition duration-300 hover:shadow-blue-500/20">

    <x-slot name="logo">
        <!-- Centramos el logo y le damos un margen inferior -->
        <div class="mb-2 flex justify-center">
            <x-authentication-card-logo />
        </div>
    </x-slot>

    <!-- Bloque de título -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
            Crea tu cuenta
        </h2>
        <p class="text-md text-gray-500 dark:text-gray-400">
            Completa tus datos para comenzar a comprar.
        </p>
    </div>
    <!-- Fin del bloque de título -->

    <!-- Re-estilizado de validación de errores -->
    <x-validation-errors class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-600 rounded-xl shadow-sm text-red-800 dark:text-red-300" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            
            {{-- Nombres --}}
            <div class="space-y-1">
                <x-label for="name" value="{{ __('Name') }}" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="name" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" placeholder="Tu nombre" />
            </div>

            {{-- Apellidos --}}
            <div class="space-y-1">
                <x-label for="last_name" value="Apellidos" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="last_name" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    type="text" name="last_name"
                    :value="old('last_name')" required autocomplete="last_name" placeholder="Tu apellido" />
            </div>

            {{-- Tipo de documento --}}
            <div class="space-y-1">
                <x-label for="document_type" value="Tipo de Documento" class="font-semibold text-gray-700 dark:text-gray-200" />
                
                {{-- Usamos la clase de input en x-select para un estilo unificado --}}
                <x-select class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3 appearance-none cursor-pointer" id="document_type" name="document_type" required>

                    {{-- El código PHP/Blade se mantiene intacto --}}
                    @foreach (\App\Enums\TypeOfDocument::cases() as $item)
                        <option value="{{ $item->value }}">
                            {{ $item->name }}
                        </option>
                    @endforeach

                </x-select>
            </div>

            {{-- Documento --}}
            <div class="space-y-1">
                <x-label for="document_number" value="Documento" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="document_number" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    name="document_number" :value="old('document_number')"
                    required placeholder="Número de documento" />
            </div>

            {{-- Email --}}
            <div class="space-y-1">
                <x-label for="email" value="{{ __('Email') }}" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="email" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    type="email" name="email" :value="old('email')"
                    required autocomplete="username" placeholder="correo@ejemplo.com" />
            </div>

            {{-- Telefono --}}
            <div class="space-y-1">
                <x-label for="phone" value="Teléfono" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="phone" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    name="phone" :value="old('phone')"
                    required placeholder="Ej: 555-123456" />
            </div>

            {{-- Password --}}
            <div class="space-y-1">
                <x-label for="password" value="{{ __('Password') }}" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="password" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    type="password" name="password" required
                    autocomplete="new-password" placeholder="••••••••" />
            </div>

            {{-- Confirm Password --}}
            <div class="space-y-1">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="password_confirmation" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3" 
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            </div>
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            {{-- Sección de Términos y Política --}}
            <div class="mt-6">
                <x-label for="terms">
                    <div class="flex items-start">
                        <x-checkbox name="terms" id="terms" required class="w-5 h-5 text-blue-600 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-blue-500 rounded-md transition duration-150 mt-1" />

                        <div class="ms-3 text-sm text-gray-600 dark:text-gray-400">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">' . __('Terms of Service') . '</a>',
                                'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">' . __('Privacy Policy') . '</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-label>
            </div>
        @endif

        <!-- Actions Section (Botón y Enlace) -->
        <div class="flex flex-col sm:flex-row-reverse sm:items-center sm:justify-between mt-6 pt-6 border-t border-gray-100 dark:border-gray-700/50">

            <!-- Register Button - Ahora en primer lugar para que sea el foco visual -->
            <x-button class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg shadow-blue-500/50 transition duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-blue-500/50 dark:focus:ring-offset-gray-800 order-1 sm:order-2">
                {{ __('Register') }}
            </x-button>

            <!-- Already Registered Link - Ahora debajo del botón en móvil y a la izquierda en desktop -->
            <a class="text-center sm:text-left text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors mt-4 sm:mt-0 underline underline-offset-4 decoration-dashed decoration-gray-300 hover:decoration-blue-500 order-2 sm:order-1"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

        </div>
    </form>
</x-authentication-card>

</x-guest-layout>