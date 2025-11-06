<x-guest-layout>
    {{-- La clase se aplica aquí para influir en el componente base, asumiendo que acepta atributos. --}}
    <x-authentication-card
        class="shadow-2xl dark:shadow-none dark:bg-gray-800/80 backdrop-blur-md rounded-3xl p-8 sm:p-10 w-full max-w-md mx-auto border border-gray-200 dark:border-gray-700 transition duration-300 hover:shadow-blue-500/20">

        <x-slot name="logo">
            <!-- Centramos el logo y le damos un margen inferior -->
            <div class="mb-2 flex justify-center">
                <x-authentication-card-logo />
            </div>
        </x-slot>

        <!-- Nuevo bloque de título moderno -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                Acceder a tu cuenta
            </h2>
            <p class="text-md text-gray-500 dark:text-gray-400">
                Ingresa tus credenciales para continuar.
            </p>
        </div>
        <!-- Fin del bloque de título -->

        <!-- Re-estilizado de validación de errores -->
        <x-validation-errors
            class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-600 rounded-xl shadow-sm text-red-800 dark:text-red-300" />

        @session('status')
            <!-- Re-estilizado del mensaje de estado (éxito) -->
            <div
                class="mb-4 p-3 font-medium text-sm bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-700 rounded-xl">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field Group -->
            <div class="space-y-1">
                <x-label for="email" value="{{ __('Email') }}" class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="email"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                    placeholder="tu@correo.com" />
            </div>

            <!-- Password Field Group -->
            <div class="mt-4 space-y-1">
                <x-label for="password" value="{{ __('Password') }}"
                    class="font-semibold text-gray-700 dark:text-gray-200" />
                <x-input id="password"
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-700/50 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 rounded-xl shadow-sm transition duration-150 p-3"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>

            <!-- Remember Me Section -->
            <div class="block mt-6">
                <label for="remember_me" class="flex items-center group cursor-pointer">
                    <!-- Checkbox styling improvement -->
                    <x-checkbox id="remember_me" name="remember"
                        class="w-5 h-5 text-blue-600 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:ring-blue-500 rounded-md transition duration-150" />
                    <span
                        class="ms-3 text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions Section (Botón y Enlace) -->
            <div
                class="flex flex-col sm:flex-row-reverse sm:items-center sm:justify-between mt-6 pt-6 border-t border-gray-100 dark:border-gray-700/50">

                <!-- Log In Button - Ahora en primer lugar para que sea el foco visual -->
                <x-button
                    class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-blue-500/50 dark:focus:ring-offset-gray-800 order-1 sm:order-2">
                    {{ __('Log in') }}
                </x-button>

                @if (Route::has('password.request'))
                    <!-- Forgot Password Link - Ahora debajo del botón en móvil y a la izquierda en desktop -->
                    <a class="text-center sm:text-left text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 transition-colors mt-4 sm:mt-0 underline underline-offset-4 decoration-dashed decoration-gray-300 hover:decoration-blue-500 order-2 sm:order-1"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            </div>
        </form>
    </x-authentication-card>

</x-guest-layout>